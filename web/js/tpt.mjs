import * as TOOLBOX from './toolbox.mjs'
import * as MOTIONS from './motions.mjs'

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


        this._classlist.forEach(classname => {
            if (classname != '' && classname !== null) {
                EL.classList.add(classname)
            };
        })
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

export class Tasks extends TemplateEngine {
    constructor (root, name, color, details, desc, labels) {
        let _name = name ?? 'Новая задача';
        let _color = color ? `${color}1f` : 'transparent';
        let _details = details ?? 'Детали задачи';
        let _desc = desc ?? 'Описание задачи';
        let _labels = Tasks.prepareLabels(labels ?? []);

        super('section', root, null, ['user-tasks__task', 'default-border', 'user-border'], null, {}, [
            [ 'div', null, { backgroundColor: _color }, ['user-tasks__task__header', 'd-flex'], null, null, 
                [ 
                    [ 'div', null, null, ['user-tasks__task__header__name'], null, null, 
                        [
                            ['h4', null, null, null, null, null, null, _name],
                            ['small', null, null, null, null, null, null, _details]
                        ]
                    ], [ 'div', null, null, ['user-tasks__task__header__labels', 'd-flex', 'flex-wrap', 'gap-2'], null, null, _labels ]
                ], 
                
            ],
            [ 'div', null, null, ['user-tasks__task__body--wrapper', 'overflow-hidden'], null, null, 
                [ ['p', null, null, ['user-tasks__task__body', 'small'], null, null, null, _desc] ]
            ]
        ]);
    }

    static prepareLabels(rawLabels) {
        let result = [];
        rawLabels.forEach(rawLabel => { result.push(['small', null, { backgroundColor: rawLabel.color }, ['user-tasks__task__header__labels__label', 'd-flex', 'justify-content-center', 'align-items-center'], null, null, null, rawLabel.text]) })

        return result;
    }
}

export class Events extends TemplateEngine {
    constructor (root, name, details, desc, labels) {
        let _name = name ?? 'Новое событие';
        let _details = details ?? 'Детали события';
        let _desc = desc ?? 'Описание события';

        super('section', root, null, ['user-events__event', 'default-border', 'user-border-bottom', 'user-border-top'], null, {}, [
            [ 'div', null, null, ['user-events__event__header', 'd-flex'], null, null, 
                [ 
                    [ 'div', null, null, ['user-events__event__header__name'], null, null, 
                        [
                            ['h4', null, null, null, null, null, null, _name],
                            ['small', null, null, null, null, null, null, _details]
                        ]
                    ]
                ], 
                
            ],
            [ 'div', null, null, ['user-events__event__body--wrapper', 'overflow-hidden'], null, null, 
                [ ['p', null, null, ['user-events__event__body', 'small'], null, null, null, _desc] ]
            ]
        ]);
    }
}

export class Forms extends TemplateEngine {
    static get PRESETS() {
        return {
            login: {
                inline: false,
                type: 'login',
                containers: [
                    { fields: [{ template: FormField.USERNAME }] },
                    { fields: [{ template: FormField.PASSWORD }] },
                    { fields: [{ template: FormField.REMEMBER }] }
                ]
            }, register: {
                inline: true,
                containers: [
                    { fields: [{ template: FormField.AUTOUSERNAME }] },
                    { fields: [{ template: FormField.AUTOPASSWORD }] },
                    { fields: [{ template: FormField.SECONDNAME }] },
                    { fields: [{ template: FormField.FIRSTNAME }] },
                    { fields: [{ template: FormField.THIRDNAME }] },
                    { fields: [{ template: FormField.CLASS }] },
                    { fields: [{ template: FormField.EMPLOYEEPOST }] },
                    { fields: [{ template: FormField.COLOR }] }
                ]
            }, registerManual: {
                inline: false,
                containers: [
                    { fields: [
                        { template: FormField.SECONDNAME },
                        { template: FormField.FIRSTNAME },
                        { template: FormField.THIRDNAME }
                    ]},
                    { fields: [{ template: FormField.AUTOUSERNAME }] },
                    { fields: [{ template: FormField.AUTOPASSWORD }] },
                    { fields: [{ template: FormField.CLASS }] },
                    { fields: [{ template: FormField.COLOR }] }
                ]
            }, tgAuthorization: {
                inline: false,
                containers: [
                    { fields: [{ template: FormField.AUTHCODE }] }
                ]
            }, schools: {
                inline: true,
                containers: [
                    { fields: [
                        { template: FormField.SCHOOLBUDGET },
                        { template: FormField.SCHOOLTYPE },
                        { template: FormField.SCHOOLNUMBER }
                    ]}, 
                    { fields: [
                        { template: FormField.SETTLEMENT },
                        { template: FormField.STREET },
                        { template: FormField.ADDRESS }
                    ]}
                ]
            }, events: {
                inline: true,
                containers: [
                    { fields: [
                        { template: FormField.EVENTTYPE },
                        { template: FormField.TIME }
                    ]}
                ],
            }, tours: {
                inline: true,
                containers: [
                    { fields: [
                        { template: FormField.SCHOOL },
                        { template: FormField.EVENT },
                    ]}
                ],
            }, meetings: {
                inline: true,
                containers: [
                    { fields: [
                        { template: FormField.EVENT },
                        { template: FormField.AUDITORIUM },
                    ]},
                    { fields: [{ template: FormField.SCHOOL }] }
                ],
            }, tasks: {
                inline: false,
                containers: [
                    { fields: [{ template: FormField.USER }] },
                    { fields: [{ template: FormField.TASKSTATUS }] },
                    { fields: [{ template: FormField.COLOR }] },
                    { fields: [{ template: FormField.SCHOOL }] },
                    { fields: [{ template: FormField.EVENT }] },
                    { fields: [{ template: FormField.NAME }] },
                    { fields: [{ template: FormField.DESCRIPTION }] },
                    { fields: [
                        { template: FormField.TIMEFROM },
                        { template: FormField.TIMETO }
                    ]}
                ],
            }, regions: {
                inline: true,
                containers: [
                    { fields: [{ template: FormField.COUNTRY }] },
                    { fields: [{ template: FormField.NAME }] }
                ],
            }, areas: {
                inline: true,
                containers: [
                    { fields: [{ template: FormField.REGION }] },
                    { fields: [{ template: FormField.NAME }] }
                ],
            }, settlements: {
                inline: true,
                containers: [
                    { fields: [{ template: FormField.AREA }] },
                    { fields: [{ template: FormField.NAME }] }
                ],
            }, managers: {
                inline: true,
                containers: [
                    { fields: [
                        { template: FormField.SCHOOL },
                        { template: FormField.EMPLOYEEPOST }
                    ]},
                    { fields: [
                        { template: FormField.SECONDNAME },
                        { template: FormField.FIRSTNAME },
                        { template: FormField.THIRDNAME }
                    ]}
                ],
            }, managersContacts: {
                inline: false,
                containers: [
                    { fields: [{ template: FormField.MANAGER }] },
                    { fields: [
                        { template: FormField.CONTACTTYPE },
                        { template: FormField.VALUE }
                    ]}
                    
                ]
            }, usersContacts: {
                inline: false,
                containers: [
                    { fields: [{ template: FormField.USER }] },
                    { fields: [
                        { template: FormField.CONTACTTYPE },
                        { template: FormField.VALUE }
                    ]}
                ]
            }
        }
    }

    static get FORMS_ERRORS() {
        return {
            'empty': 'Поле не может быть пустым',
            'min_length': 'Поле должно содержать минимум символов: ',
            'max_length': 'Поле может содержать максимум символов: ',
            'value_invalid': 'Поле содержит неверное значение',
            'unique': 'Это уже было!'
        }
    }

    static async begin(root, name, struct = {}, id = null) {
        let parsedStruct = await Forms.parseStruct(name, struct);
        let parsedService = await Forms.prepareServiceFields(name);
        return new Forms(root, name, parsedService.concat(parsedStruct).concat(Forms.prepareSubmitButton(struct.type ?? 'Сохранить')), id);
    }

    constructor (root, name, struct = {}, id = null) {
        super(
            'form', 
            root, 
            null,
            ['form'],
            id, 
            { 'data-name': name },  
            struct,
            null,
            null, 
            null,
            (tpt) => {
                tpt._el.addEventListener('submit', async e => {
                    e.preventDefault();

                    const VALIDATION_RESULT = await Forms.formValidation(e.currentTarget);
                    if (VALIDATION_RESULT) {
                        console.log('form valid!');
                    } else MOTIONS.shake(e.submitter);
                })
            }
        )
    }

    static async formValidation(form) {
        const FIELD_GROUPS = form.querySelectorAll('.form-group__field-group');
        FIELD_GROUPS.forEach(async fieldGroup => {
            const FIELD_INPUT = fieldGroup.querySelector('.form-group__field-group__field');
            const FIELD_NAME = FIELD_INPUT.getAttribute('name');
            if ((typeof form.dataset === 'undefined' || typeof form.dataset.valid === 'undefined' || form.dataset.valid[FIELD_NAME] !== 'true') && !(await Forms.validation(fieldGroup, form.dataset.name))) return false;
        })
    }

    static async validation(fieldGroup, formName) {
        const FORM = document.querySelector(`form[data-name="${formName}"]`);
        const FIELD_ERROR = fieldGroup.querySelector('.form-group__field-group__error');
        const FIELD_INPUT = fieldGroup.querySelector('.form-group__field-group__field');

        let result = await Forms.validateField(FIELD_INPUT, formName);
        if (result !== null) {
            FORM.setAttribute(`data-valid-${FIELD_INPUT.dataset.name}`, false);
            FIELD_INPUT.classList.add('invalid');
            FIELD_ERROR.innerText = result;
        } else {
            FORM.setAttribute(`data-valid-${FIELD_INPUT.dataset.name}`, true);
            if (FIELD_INPUT.classList.contains('invalid')) FIELD_INPUT.classList.remove('invalid');
            FIELD_INPUT.classList.add('valid');
            FIELD_ERROR.innerText = '';
        }
    }

    static async validateField(field, formName) {
        for (const [err, msg] of Object.entries(Forms.FORMS_ERRORS)) {
            switch (err) {
                case 'empty':
                    if (field.getAttribute('required') && field.value === null || field.value === '') return msg;
                    break;
                case 'min_length':
                    if (typeof field.dataset?.min !== 'undefined' && String(field.value).length < field.dataset.min) return msg + field.dataset.min;
                    break;
                case 'max_length':
                    if (typeof field.dataset?.max !== 'undefined' && String(field.value).length > field.dataset.max) return msg + field.dataset.max;
                    break;
                case 'value_invalid':
                    if (typeof field.dataset?.template !== 'undefined' && !(String(field.value.match).match(field.dataset.template))) return msg;
                    break;
                case 'unique':
                    if (field.getAttribute('unique') && field.value !== null && field.value !== '' && await Forms.__validateUnique(field.value, formName)) return msg;
                    break;
            }
        }

        return null;
    }

    static async __validateUnique(value, formName) {
        let preparsedData = await fetch(`${window.__api.unique}/${formName}?val=${field.value}`);
        return await preparsedData.json().unique;
    }

    static async parseStruct(name, struct) {

        let result = [];
        for (const container of struct.containers) {
            result.push([
                (container.inline ? 'td' : 'div'), 
                null,
                null, 
                ['form-group', (container.inline ? 'form-group-inline' : 'form-group-default')], 
                null,
                null,
                await Forms.prepareFields(container.fields, name)
            ]);
        }

        return result;
    }
    
    static async prepareFields(fieldsArray, name) {
        let result = [];

        // MAY CAUSE PROBLEMS WITH RANDOM POSITION OF FIELDS...
        for (const field of fieldsArray) {
            result.push([
                'div',
                null,
                null,
                ['form-group__field-group'],
                null,
                null,
                [
                    ['label', null, { display: (field.template.type == 'checkbox' ? 'none': 'block') }, ['form-group__field-group__label'], null, null, null, `${field.template.label}${field.template.required ? ' <span class="form-group__field-group__label--required">*</span>': ''}`],
                    await Forms.prepareField(field.template, name),
                    ['small', null, null, ['form-group__field-group__error'], null, null, null, '']
                ]
            ]);
        }

        return result;
    }
    
    static async prepareField(fieldStruct, name) {
        let result = [];

        switch (fieldStruct.type) {
            case 'select':
                result = [
                    'select',
                    null,
                    null,
                    ['form-group__field-group__field', 'form-group__field-group__field__select'],
                    null,
                    { 
                        name: `${name}[${fieldStruct.name}]`,
                        placeholder: fieldStruct.placeholder ?? fieldStruct.label,
                        'aria-label': fieldStruct.label,
                        ...(typeof fieldStruct.value !== 'undefined' && { value: fieldStruct.value }),
                        ...(typeof fieldStruct.required !== 'undefined' && { required: true }),
                        ...(typeof fieldStruct.required !== 'undefined' && { 'aria-required': true })
                    },
                    this.prepareSelectOptions(Array.isArray(fieldStruct.data) ? fieldStruct.data : await Forms.getAjaxOptions(fieldStruct.data))
                ];
                break;
            case 'textarea':
                result = [
                    'textarea',
                    null,
                    null,
                    ['form-group__field-group__field', 'form-group__field-group__field__textarea'],
                    `form-field-${fieldStruct.name}--${fieldStruct.type}`,
                    { 
                        name: `${name}[${fieldStruct.name}]`,
                        'data-name': fieldStruct.name,
                        'aria-label': fieldStruct.label,
                        placeholder: fieldStruct.placeholder ?? fieldStruct.label,
                        ...(typeof fieldStruct.value !== 'undefined' && { value: fieldStruct.value }),
                        ...(typeof fieldStruct.required !== 'undefined' && { required: true }),
                        ...(typeof fieldStruct.required !== 'undefined' && { 'aria-required': true }),
                        ...(typeof fieldStruct?.length?.min !== 'undefined' && { 'data-min': fieldStruct.length.min }),
                        ...(typeof fieldStruct?.length?.max !== 'undefined' && { 'data-max': fieldStruct.length.max })
                    },
                    null,
                    null,
                    null,
                    null,
                    (tpt) => { tpt._el.addEventListener('keyup', async e => { await Forms.validation(e.currentTarget.parentNode, name) }) }
                ];
                break;
            case 'checkbox':
                result = [
                    'div',
                    null,
                    null,
                    ['switch-container--wrapper'],
                    null,
                    null,
                    [
                        [
                            'div',
                            null,
                            null,
                            ['switch-container'],
                            null,
                            null,
                            [
                                ['input', null, null, ['switch-container__trigger--input', 'form-group__field-group__field'], null, { 
                                    'aria-label': fieldStruct.label,
                                    type: 'checkbox',
                                    placeholder: fieldStruct.placeholder ?? fieldStruct.label,
                                    ...(typeof fieldStruct.value !== 'undefined' && { checked: true }),
                                    ...(typeof fieldStruct.required !== 'undefined' && { required: true }),
                                    ...(typeof fieldStruct.required !== 'undefined' && { 'aria-required': true }),
                                }]
                            ],
                            null,
                            fieldStruct.placeholder ?? fieldStruct.label,
                            null,
                            (tpt) => {
                                tpt._el.addEventListener('click', e => {
                                    if (e.currentTarget.classList.contains('checked')) {
                                        e.currentTarget.querySelector('input[type="checkbox"]').checked = true;
                                        e.currentTarget.classList.remove('checked');
                                    } else {
                                        e.currentTarget.querySelector('input[type="checkbox"]').checked = false;
                                        e.currentTarget.classList.add('checked');
                                    }
                                })
                            }
                        ]
                    ]
                ];

                if (fieldStruct.value) result[7][1][4].push('checked');
                break;
            default:
                result = [
                    'input',
                    null,
                    { display: (fieldStruct.hidden ? 'none' : 'block' ) },
                    ['form-group__field-group__field', `form-group__field-group__field__input--${fieldStruct.type}`],
                    `form-field-${fieldStruct.name}--${fieldStruct.type}`,
                    { 
                        type: fieldStruct.type,
                        name: fieldStruct.name == '_csrf' ? fieldStruct.name : `${name}[${fieldStruct.name}]`,
                        placeholder: fieldStruct.placeholder ?? fieldStruct.label,
                        'aria-label': fieldStruct.label,
                        ...(typeof fieldStruct.value !== 'undefined' && { value: fieldStruct.value }),
                        ...(typeof fieldStruct.required !== 'undefined' && { required: true }),
                        ...(typeof fieldStruct.required !== 'undefined' && { 'aria-required': true }),
                        ...(typeof fieldStruct?.length?.min !== 'undefined' && { 'data-min': fieldStruct.length.min }),
                        ...(typeof fieldStruct?.length?.max !== 'undefined' && { 'data-max': fieldStruct.length.max })
                    },
                    null,
                    null,
                    null,
                    null,
                    (tpt) => { tpt._el.addEventListener('keyup', async e => { await Forms.validation(e.currentTarget.parentNode, name) }) }
                ];
                break;
        }
        
        return result;
    }

    static prepareSelectOptions(options, preselected = null) {
        let result = [];
        for (const [id, text] of Object.entries(options)) {
            result.push([
                'option',
                null,
                null,
                ['form-group__field-group__field__select--option'],
                null,
                {
                    value: id,
                    ...(typeof preselected === id && { selected: true })
                },
                text,
            ])
        }

        return result;
    }

    static async prepareServiceFields(name) {
        let result = [];
        result.push(await Forms.prepareField(FormField.CSRF, name));
        result.push(await Forms.prepareField(FormField.ID, name));

        return result;
    }

    static prepareSubmitButton(label) {
        return [
            [
                'button',
                null,
                null,
                ['form-submit'],
                null,
                { type: 'submit' },
                null,
                label
            ]
        ];
    }

    static async getAjaxOptions(dataName) {
        let preparsedData = await fetch(`${window.__api.select}/${dataName}`);
        return await preparsedData.json();
    }
}

class FormField {
    static get CSRF() {
        return {
            name: '_csrf',
            label: 'CSRF-токен',
            type: 'text',
            value: window.__user.__csrf,
            hidden: true,
            required: true
        }
    } static get ID() {
        return {
            name: 'id',
            label: 'Код',
            type: 'integer',
            hidden: true
        }
    } static get USERNAME() {
        return {
            name: 'username',
            label: 'Логин',
            type: 'text',
            placeholder: 'Очень запоминающийся логин',
            length: {
                min: 5,
                max: 20
            },
            required: true
        }
    } static get AUTOUSERNAME() {
        return {
            name: 'username',
            label: 'Логин',
            type: 'text',
            value: `user_${TOOLBOX.generateRandomString(5)}_${String(Date.now()).substring(11) + Math.floor(Math.random() * 100)}`,
            placeholder: 'Очень запоминающийся логин',
            length: {
                min: 5,
                max: 20
            },
            required: true
        }
    } static get PASSWORD() {
        return {
            name: 'password',
            label: 'Пароль',
            type: 'password',
            placeholder: 'Очень сложный пароль',
            length: {
                min: 8,
                max: 16
            },
            required: true
        }
    } static get AUTOPASSWORD() {
        return {
            name: 'password',
            label: 'Пароль',
            type: 'password',
            value: TOOLBOX.generateRandomString(8),
            length: {
                min: 8,
                max: 16
            },
            placeholder: 'Очень сложный пароль',
            required: true
        }
    } static get REMEMBER() {
        return {
            name: 'remember',
            label: 'Запомнить меня',
            type: 'checkbox'
        }
    } static get FIRSTNAME() {
        return {
            name: 'firstname',
            label: 'Имя',
            type: 'text',
            required: true
        }
    } static get SECONDNAME() {
        return {
            name: 'secondname',
            label: 'Фамилия',
            type: 'text',
            required: true
        }
    } static get THIRDNAME() {
        return {
            name: 'thirdname',
            label: 'Отчество',
            type: 'text', 
        }
    } static get COLOR() {
        return {
            name: 'color_id',
            label: 'Любимый цвет',
            type: 'select',
            value: '-1',
            data: 'colors', 
        }
    } static get EMPLOYEEPOST() {
        return {
            name: 'employee_posts_id',
            label: 'Должность',
            type: 'select',
            value: 12,
            data: {
                1: 'Администратор',
                2: 'Директор',
                3: 'Зам. директора по учебно-воспитательной работе',
                4: 'Зам. директора по методической работе',
                5: 'Зам. директора по внеклассной работе',
                6: 'Классный руководитель',
                7: 'Помощник директора',
                8: 'Советник директора',
                9: 'Спец. отдела проф. ориентации',
                10: 'Нач. отдела проф. ориентации',
                11: 'Водитель',
                12: 'Учащийся'
            }, 
        }
    } static get CLASS() {
        return {
            name: 'classes_id',
            label: 'Школа',
            type: 'select',
            data: 'classes', 
        }
    } static get AUTHCODE() {
        return {
            name: 'auth_code',
            label: 'Код подтверждения',
            type: 'number',
            required: true
        }
    } static get SCHOOLNUMBER() {
        return {
            name: 'number',
            label: 'Номер школы',
            type: 'text',
            required: true
        }
    } static get SCHOOLBUDGET() {
        return {
            name: 'schools_budget_type_id',
            label: 'Тип финансирования',
            type: 'select',
            value: 2,
            data: {
                1: 'МКОУ',
                2: 'МБОУ',
                3: 'ГБОУ',
                4: 'МАОУ',
                5: 'ЧОУ'
            },
            required: true
        }
    } static get SCHOOLTYPE() {
        return {
            name: 'schools_education_type_id',
            label: 'Тип образования',
            type: 'select',
            value: 3,
            data: {
                1: 'НОШ',
                2: 'ООШ',
                3: 'СОШ',
                4: 'МШ'
            },
            required: true
        }
    } static get STREET() {
        return {
            name: 'street',
            label: 'Улица, проспект, пр.',
            type: 'text',
            required: true
        }
    } static get ADDRESS() {
        return {
            name: 'address',
            label: 'Дом, корпус, строение, пр.',
            type: 'text',
            required: true
        }
    } static get COUNTRY() {
        return {
            name: 'country_id',
            label: 'Страна',
            type: 'select',
            value: 1,
            data: {
                1: 'Россия'
            },
            required: true
        }
    } static get REGION() {
        return {
            name: 'region_id',
            label: 'Регион',
            type: 'select',
            value: 32,
            data: {
                1: 'Республика Адыгея',
                2: 'Республика Алтай',
                3: 'Республика Башкортостан',
                4: 'Республика Бурятия',
                5: 'Республика Дагестан',
                6: 'Донецкая Народная Республика',
                7: 'Республика Ингушетия',
                8: 'Кабардино-Балкарская Республика',
                9: 'Республика Калмыкия',
                10: 'Карачаево-Черкесская Республика',
                11: 'Республика Карелия',
                12: 'Республика Коми',
                13: 'Республика Крым',
                14: 'Луганская Народная Республика',
                15: 'Республика Марий Эл',
                16: 'Республика Мордовия',
                17: 'Республика Саха',
                18: 'Республика Северная Осетия',
                19: 'Республика Татарстан',
                20: 'Республика Тыва',
                21: 'Удмуртская Республика',
                22: 'Республика Хакасия',
                23: 'Чеченская Республика',
                24: 'Чувашская Республика',
                25: 'Алтайский край',
                26: 'Забайкальский край',
                27: 'Камчатский край',
                28: 'Краснодарский край',
                29: 'Красноярский край',
                30: 'Пермский край',
                31: 'Приморский край',
                32: 'Ставропольский край',
                33: 'Хабаровский край',
                34: 'Амурская область',
                35: 'Архангельская область',
                36: 'Астраханская область',
                37: 'Белгородская область',
                38: 'Брянская область',
                39: 'Владимирская область',
                40: 'Волгоградская область',
                41: 'Вологодская область',
                42: 'Воронежская область',
                43: 'Запорожская область',
                44: 'Ивановская область',
                45: 'Иркутская область',
                46: 'Калининградская область',
                47: 'Калужская область',
                48: 'Кемеровская область',
                49: 'Кировская область',
                50: 'Костромская область',
                51: 'Курганская область',
                52: 'Курская область',
                53: 'Ленинградская область',
                54: 'Липецкая область',
                55: 'Магаданская область',
                56: 'Московская область',
                57: 'Мурманская область',
                58: 'Нижегородская область',
                59: 'Новгородская область',
                60: 'Новосибирская область',
                61: 'Омская область',
                62: 'Оренбургская область',
                63: 'Орловская область',
                64: 'Пензенская область',
                65: 'Псковская область',
                66: 'Ростовская область',
                67: 'Рязанская область',
                68: 'Самарская область',
                69: 'Саратовская область',
                70: 'Сахалинская область',
                71: 'Свердловская область',
                72: 'Смоленская область',
                73: 'Тамбовская область',
                74: 'Тверская область',
                75: 'Томская область',
                76: 'Тульская область',
                77: 'Тюменская область',
                78: 'Ульяновская область',
                79: 'Херсонская область',
                80: 'Челябинская область',
                81: 'Ярославская область',
                82: 'Москва',
                83: 'Санкт-Петербург',
                84: 'Севастополь',
                85: 'Еврейская автономная область',
                86: 'Ненецкий автономный округ',
                87: 'Ханты-Мансийский автономный округ',
                88: 'Чукотский автономный округ',
                89: 'Ямало-Ненецкий автономный округ'
            },
            required: true
        }
    } static get AREA() {
        return {
            name: 'area_id',
            label: 'Район, городской округ',
            type: 'select',
            value: 1,
            data: 'areas',
            required: true
        }
    } static get SETTLEMENT() {
        return {
            name: 'settlements_id',
            label: 'Населённый пункт',
            type: 'select',
            value: 1,
            data: 'settlements',
            required: true
        }
    } static get TIME() {
        return {
            name: 'epoch',
            label: 'Время',
            type: 'date',
            required: true,
            beforesubmit: (value) => {
                return String(new Date(value).valueOf()).substring(0, 10)
            }
        }
    } static get TIMEFROM() {
        return {
            name: 'epoch_from',
            label: 'Начало',
            type: 'date',
            required: true,
            beforesubmit: (value) => {
                return String(new Date(value).valueOf()).substring(0, 10)
            }
        }
    } static get TIMETO() {
        return {
            name: 'epoch_to',
            label: 'Конец',
            type: 'date',
            required: true,
            beforesubmit: (value) => {
                return String(new Date(value).valueOf()).substring(0, 10)
            }
        }
    } static get EVENTTYPE() {
        return {
            name: 'event_type_id',
            label: 'Тип события',
            type: 'select',
            required: true,
            value: 4,
            data: {
                1: 'Фестиваль профессий СмК',
                2: 'Фестиваль профессий IThub',
                3: 'Фестиваль профессий мед. колледж',
                4: 'Командировка СмК',
                5: 'Командировка IThub',
                6: 'Командировка мед. колледж',
                7: 'Родительское собрание СмК',
                8: 'Родительское собрание IThub',
                9: 'Родительское собрание мед. колледж',
                10: 'Открытый урок СмК',
                11: 'Открытый урок IThub',
                12: 'Открытый урок мед. колледж',
                13: 'Дистанционная работа СмК',
                14: 'Дистанционная работа IThub',
                15: 'Дистанционная работа мед. колледж',
            }
        }
    } static get SCHOOL() {
        return {
            name: 'schools_id',
            label: 'Школа',
            type: 'select',
            data: 'schools',
            required: true
        }
    } static get EVENT() {
        return {
            name: 'events_id',
            label: 'Событие',
            type: 'select',
            data: 'events',
            required: true
        }
    } static get AUDITORIUM() {
        return {
            name: 'auditoriums_id',
            label: 'Аудитория',
            type: 'select',
            data: {
                1: 'Л102',
                2: 'Л104',
                3: 'Л106',
                4: 'Л110',
                5: 'Л203',
                6: 'Л204',
                7: 'Л205',
                8: 'Л206',
                9: 'Л208',
                10: 'Л211',
                11: 'Л212',
                12: 'Л213',
                13: 'Л219',
                14: 'Л220',
                15: 'Л2А',
                16: 'Л401',
                17: 'Л403',
                18: 'Л404',
                19: 'Л405',
                20: 'Л406',
                21: 'Л407',
                22: 'Л408',
                23: 'Л409',
                24: 'Л410',
                25: 'Л411',
                26: 'Л417',
                27: 'Л418',
                28: 'Л421',
                29: 'Л422',
                30: 'Л4А',
                31: 'К201',
                32: 'К202',
                33: 'К203',
                34: 'К204',
                35: 'К205',
                36: 'К206',
                37: 'К207',
                38: 'К208',
                39: 'К211',
                40: 'К212',
                41: 'К213',
                42: 'К214-215',
                43: 'К216',
                44: 'К217',
                45: 'К218',
                46: 'К219',
                47: 'К220-221',
                48: 'Э301',
                49: 'Э302',
                50: 'Э304',
                51: 'Э305',
                52: 'Э307',
                53: 'Э308',
                54: 'Э309',
                55: 'Э309-1',
                56: 'Э311',
                57: 'Э312',
                58: 'Э313',
                59: 'Э314',
                60: 'Э315',
                61: 'Ж1',
                62: 'Ж10',
                63: 'Ж11',
                64: 'Ж12 ',
                65: 'Ж13',
                66: 'Ж14',
                67: 'Ж15',
                68: 'Ж16',
                69: 'Ж17',
                70: 'Ж18',
                71: 'Ж19',
                72: 'Ж2',
                73: 'Ж20(12)',
                74: 'Ж21',
                75: 'Ж3',
                76: 'Ж4',
                77: 'Ж5',
                78: 'Ж6',
                79: 'Ж8',
                80: 'Ж9'
            },
            required: true
        }
    } static get USER() {
        return {
            name: 'users_id',
            label: 'Пользователь',
            type: 'select',
            data: 'users',
            required: true
        }
    } static get USERS() {
        return {
            name: 'users_id',
            label: 'Пользователь',
            type: 'select',
            data: 'users',
            multiple: true
        }
    } static get TASKSTATUS() {
        return {
            name: 'users_id',
            label: 'Статус задачи',
            type: 'select',
            data: 'task_status',
            required: true
        }
    } static get NAME() {
        return {
            name: 'name',
            label: 'Название',
            type: 'text',
            required: true
        }
    } static get VALUE() {
        return {
            name: 'value',
            label: 'Значение',
            type: 'text',
            required: true
        }
    } static get DESCRIPTION() {
        return {
            name: 'description',
            label: 'Описание',
            type: 'textarea', 
        }
    } static get CONTACTTYPE() {
        return {
            name: 'contacts_type_id',
            label: 'Тип контактных данных',
            type: 'select',
            data: 'contacts_type',
            required: true
        }
    } static get MANAGER() {
        return {
            name: 'managers_id',
            label: 'Руководитель ОУ',
            type: 'select',
            data: 'managers',
            required: true
        }
    }
}