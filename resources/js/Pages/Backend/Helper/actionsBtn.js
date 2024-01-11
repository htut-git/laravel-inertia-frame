export default class ActionBtn {
    constructor() { }
    static editBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="btn btn-primary btn btn-sm editBtn"><i class="fa-solid fa-pen-to-square"></i></button>`,
            class: '.editBtn'
        };
    }

    static deleteBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="btn btn-danger btn btn-sm deleteBtn"><i class="fa-solid fa-trash"></i></button>`,
            class: '.deleteBtn'
        };
    }
}
