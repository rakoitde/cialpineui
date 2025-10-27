<script>
     document.addEventListener('alpine:init', () => {

        Alpine.magic('cell', (el, { Alpine }) => {

            if (!el.__cellTimers) el.__cellTimers = new Set();

            return new Proxy(Alpine.$data(el), {
                
                get(_, method) {
                    
                    if (method in _ && typeof _[method] !== 'function') {
                        return _[method];
                    }
                    
                    const callBackend = async (...args) => {

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

                            if (el.__cellTimers) {
                                for (const t of el.__cellTimers) clearInterval(t);
                                el.__cellTimers.clear();
                            }
                            root.outerHTML = result.html;
                            return;

                        } 
                        
                        for (const key in result) {
                            if (typeof componentData[key] !== 'function') {
                                componentData[key] = result[key]
                            }
                        }

                        return result;
                    };

                    const cellProxy = new Proxy(callBackend, {
                        get(target, prop) {

                            if (prop === 'interval') {
                    
                                    return (delay, ...args) => {
                                        const ms = parseInt(delay);
                                        if (isNaN(ms)) {
                                            throw new Error(`Invalid interval delay: ${delay}`);
                                        }

                                        const timer = setInterval(() => target(...args), ms);

                                        el.__cellTimers.add(timer);

                                        if (Alpine.version && Alpine.version.startsWith('3.13')) {
                                            $cleanup(() => {
                                                clearInterval(timer);
                                                el.__cellTimers.delete(timer);
                                            });
                                        } else {
                                            el.addEventListener('destroy', () => {
                                                clearInterval(timer);
                                                el.__cellTimers.delete(timer);
                                            });
                                        }

                                        return timer;
                                    };
                            }

                            return target[prop];
                        },
                    });

                    return cellProxy;

                }
            });
        });

    

     })
 </script>