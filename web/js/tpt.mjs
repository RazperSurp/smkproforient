import * as TOOLBOX from './toolbox.mjs'

export class TemplateEngine {
    static get TPLT_TABLE() { return 1 };

    _tagName;
    _rootEl;
    _style;
    _classlist;
    _id;
    _attributes;
    _children;
    _content;

    _el;

    constructor (tagName, rootSelector, style, classlist, id, attributes, children, text, html, beforeInsert, beforeChildren) {
        this._tagName = tagName ?? 'div';
        this._rootEl = rootSelector instanceof HTMLElement ? rootSelector : document.querySelector(rootSelector ?? 'body');
        this._style = style ?? {};
        this._classlist = classlist ?? [];
        this._id = id ?? TOOLBOX.generateRandomString(5, true, false);
        this._attributes = attributes ?? {};
        this._children = children ?? [];
        this._content = {
            text: html ?? text ?? '',
            isHtml: html !== null
        }

        return this._generateEl(beforeInsert, beforeChildren);
    }

    _generateEl(beforeInsert, beforeChildren) {
        this._bornVirtual();

        if (beforeInsert && typeof beforeInsert == 'function') beforeInsert(this);
        this._rootEl.append(this._el);

        if (beforeChildren && typeof beforeChildren == 'function') beforeChildren(this);
        this._appendChildren();

        if (this._el instanceof HTMLElement) window.TemplateEngine.elements[this._id] = this;
        
        return { id: this._id, el: this._el };
    }

    _bornVirtual() {
        const EL = document.createElement(this._tagName);

        for (const [attribute, value] of Object.entries(this._attributes)) EL.setAttribute(attribute, value);
        for (const [property, value] of Object.entries(this._style)) EL.style[property] = value;


        this._classlist.forEach(classname => { EL.classList.add(classname) });
        EL.setAttribute('id', this._id);

        EL[this._content.isHtml ? 'innerHTML' : 'innerText'] = this._content.text;

        this._el = EL;
    }

    _appendChildren() {
        this._children.forEach(child => {
            child[1] = `#${this._id}`;
            
            new TemplateEngine(...child);
        })
    }
}

export class SvgEngine extends TemplateEngine {
    static getFilePath(name) { return `/web/svg/${name.replace(/[^+\w]/g, '')}.svg`; }

    constructor (name, rootSelector) {
        super ('img', rootSelector, { height: '100%' }, null, null, { src: SvgEngine.getFilePath(name) });
    }
}