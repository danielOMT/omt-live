(function () {
    if ('ontouchstart' in document.documentElement) {
        document.addEventListener('touchstart', onTouchStart, {passive: true});
    }
    var supportsPassive = eventListenerOptionsSupported();

    if (supportsPassive) {
        var addEvent = EventTarget.prototype.addEventListener;
        overwriteAddEvent(addEvent);
    }

    function overwriteAddEvent(superMethod) {
        var defaultOptions = {
            passive: true,
            capture: false
        };

        EventTarget.prototype.addEventListener = function (type, listener, options) {
            var usesListenerOptions = typeof options === 'object';
            var useCapture = usesListenerOptions ? options.capture : options;

            options = usesListenerOptions ? options : {};

            if (type == 'touchstart' || type == 'scroll' || type == 'wheel') {
                options.passive = options.passive !== undefined ? options.passive : defaultOptions.passive;
            }

            options.capture = useCapture !== undefined ? useCapture : defaultOptions.capture;

            superMethod.call(this, type, listener, options);
        };
    }

    function eventListenerOptionsSupported() {
        var supported = false;
        try {
            var opts = Object.defineProperty({}, 'passive', {
                get: function () {
                    supported = true;
                }
            });
            window.addEventListener("test", null, opts);
        } catch (e) { }

        return supported;
    }
})();

jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ){
        this.addEventListener("touchstart", handle, { passive: true });
    }
};

// Test via a getter in the options object to see if the passive property is accessed

$.event.special.touchstart = {
    setup: function( _, ns, handle ){
        this.addEventListener("touchstart", handle, { passive: true });
    }
};