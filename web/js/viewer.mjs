import { SvgEngine } from "./tpt.mjs";


export class Viewer {
    specialElements = {};

    get _SPECIAL_ATTRIBUTES() {
        return {
            'cc-svg': '_appendSvg'
        };
    }

    constructor () {
        Object.keys(this._SPECIAL_ATTRIBUTES).forEach(attribute => {
            this.specialElements[attribute] = [];
            this._scan(attribute);
        })

        for (const [attribute, fn] of Object.entries(this._SPECIAL_ATTRIBUTES)) {
            this.specialElements[attribute].forEach(specialElement => {
                this[fn](specialElement.el, specialElement.value);
            })
        }
    }

    _scan(attribute) {
        document.querySelectorAll(`[${attribute}]`).forEach(element => {
            this.specialElements[attribute].push({ el: element, value: element.getAttribute(attribute) });
        });
    }

    _appendSvg(el, value) {
        return new SvgEngine(value, el);
    }
}