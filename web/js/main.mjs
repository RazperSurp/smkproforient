import * as TOOLBOX from './toolbox.mjs'
import { TemplateEngine, SvgEngine } from './tpt.mjs'
import { Viewer } from './viewer.mjs'

window.TemplateEngine = { class: TemplateEngine, elements: {} }

// document.addEventListener('DOMContentLoaded', () => {
    new Viewer();
// })