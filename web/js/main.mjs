import * as TOOLBOX from './toolbox.mjs'
import * as MOTIONS from './motions.mjs'
import { TemplateEngine, SvgEngine, Tasks, Events } from './tpt.mjs'
import { Viewer } from './viewer.mjs'

window.TemplateEngine = { class: TemplateEngine, elements: {} }
window.ToolBox = TOOLBOX;
window.Motions = MOTIONS;

new Viewer();