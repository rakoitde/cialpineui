<script>
     document.addEventListener('alpine:init', () => {

        Alpine.magic('cell', (el, { Alpine }) => {
            return new Proxy(Alpine.$data(el), {
                
                get(_, method) {
                    
                    if (method in _ && typeof _[method] !== 'function') {
                        return _[method];
                    }
                    
                    return async (...args) => {

                        // replace forms in formData
                        args.forEach((arg, index) => {
                            if (arg.tagName == 'FORM') {
                                args[index] = Object.fromEntries(new FormData(arg))
                            }
                        })

                        const componentData = Alpine.$data(el);

                        const oldData = JSON.parse(JSON.stringify(componentData))
            

                        const root = Alpine.closestRoot(el)
                        const componentId = root.getAttribute('x-id') || null
                        const componentAttr = root.getAttribute('x-component');
                        if (!componentAttr) {
                            throw new Error('Missing x-component attribute in root element');
                        }
                        const componentName = componentAttr.replaceAll('\\', '/');

                        const body = {
                            component: { 
                                id: componentId,
                                name: componentName,
                            },
                            data: oldData,
                            request: {
                                action: method,
                                params: args,
                            }
                        }

                        const url = 'component'
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(body)
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`Server responded with ${response.status}`);
                        }

                        const result = await response.json();

                        if (result.html) {

                            root.outerHTML = result.html;

                        } else {

                            const newData = result
    
                            for (const key in newData) {
                                if (typeof componentData[key] !== 'function') {
                                    componentData[key] = newData[key]
                                }
                            }
                        }

                        return result;
                    }
                }
            });
        });

    

     })
 </script>