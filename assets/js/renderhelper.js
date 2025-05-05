class RenderHelper {
    name;
    control;
    _state;

    rootEl;
    groupEls;
    targetEl;

    _groupSelector;
    _targetSelector

    static generateRandomString(length = 5, includeNumbers = true, includeSpecials = false, allowRepeat = false) {
        const ALPHABET = 'abcdefghijklmnopqrstuvwxyz';
        const NUMBERS = '0123456789';
        const SPECIALS = '!@#$%^&*()_-+={[}]?/\~|><';

        let index, 
            result = '', 
            letterBase = (ALPHABET + (includeNumbers ? NUMBERS : '') + (includeSpecials ? SPECIALS : '')).split('');

        for (let i = 0; i < length; i++) {
            do {
                index = Math.round(Math.random() * letterBase.length);
            } while (letterBase[index] === null);

            result += letterBase[index];
            if (!allowRepeat) letterBase[index] = null;
        }

        return result;
    }

    static scan() {
        document.querySelectorAll('[rh-cmpnt]').forEach(el => {new RenderHelper(el)})
    }

    constructor (el) {
        el.id = el.id ? el.id : RenderHelper.generateRandomString();

        this.name = el.getAttribute('rh-cmpnt');
        this.rootEl = el;
        this._state = el.getAttribute('aria-state') == 'true';
        this._groupSelector = el.getAttribute('aria-group');
        this.control = el.getAttribute('aria-controls');
        this._targetSelector = el.getAttribute('aria-target');
        this.targetEl = this._targetSelector ? document.querySelector(this._targetSelector) : null;
        this.groupEls = this._groupSelector ? { 
            masters: document.querySelectorAll(`[aria-group="${this._groupSelector}"]:not([id="${el.id}"])`),
            slaves: document.querySelectorAll(this._groupSelector)
        } : null;

        window.RH = window.RH ?? {}
        window.RH[el.id] = this;

        this._processMutations();

    }

    /**
     * @param {any} value
     */
    set state(value) {
        if (value !== this._state) {
            console.log([this, this._state])
            this._actualizeGroup();

            this._state = value ? true : false;
            this.rootEl.setAttribute('aria-state', this._state);
            
            this._actualizeTarget();
        }
    }

    _actualizeGroup() {
        this.groupEls.masters.forEach(el => {
            if (window.RH[el.id]._state != "false") window.RH[el.id].state = false;
        })
    }

    _actualizeTarget() {
        this.targetEl.classList[this._state == '1' ? 'add' : 'remove'](this.control);
    }

    _processMutations() {
        const observer = new MutationObserver(mutations => { for (const MUTATION of mutations) this._parseMutation(MUTATION) })
        observer.observe(this.rootEl, { attributes: true });

        this.rootEl.addEventListener('click', e => { this.state = !this._state; });
        document.body.addEventListener('click', e => {
            if (e.target !== this.rootEl && !this.targetEl.contains(e.target)) {
                this.state = false;
            }
        })
    }

    _parseMutation(mutation) {
        switch (mutation.attributeName) {
            case 'aria-state':
                if (this.state != mutation.target.getAttribute(mutation.attributeName))
                    this.state = mutation.target.getAttribute(mutation.attributeName) == 'true';
                break;
        }
    }
}