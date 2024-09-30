export function shake(el) {
    if (!el.classList.contains('shaking')) {

        const SHAKE_DIAMETER = 6;
        const SHAKE_RADIUS = Math.floor(SHAKE_DIAMETER / 2);
        const START_LEFT = el.style.left ? Number(el.style.left.substring(0, el.style.left.indexOf('px'))) : 0;
        const START_POSITION = el.style.position ?? 'static';
        const START_TRANSITION = el.style.transition ?? 'unset';

        el.classList.add('shaking');
        el.style.position = 'relative';
        el.style.left = `${START_LEFT}px`;
        el.style.transition = '0.075s';

        function shakeRight(el) {
            el.style.left = `${START_LEFT + SHAKE_RADIUS}px`; 
        }

        function shakeLeft(el) {
            el.style.left = `${START_LEFT - SHAKE_RADIUS}px`;
        }

        _interval(150, () => {
            shakeRight(el);
            setTimeout(() => {
                shakeLeft(el);
            }, 50);
            setTimeout(() => {
                el.style.left = `${START_LEFT}px`;
            }, 100);
        }, (i) => {
            if (i >= 3) {
                setTimeout(() => {
                    el.classList.remove('shaking');
                    el.style.position = START_POSITION;
                    el.style.transition = START_TRANSITION;
                }, 150);
                return true;
            } 
        })
    }
}

function _interval(timeout, handler, closer) {
    let iteration = 0;
    const INTERVAL = setInterval(() => {
        // console.log(iteration);
        handler(iteration);
        if (closer(iteration)) clearInterval(INTERVAL);
        iteration++;
    }, timeout);
}