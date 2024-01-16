export default class ActionBtn {
    constructor() { }
    static editBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="btn-default editBtn"></i> Edit</button>`,
            class: '.editBtn'
        };
    }

    static deleteBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="btn-danger
            deleteBtn"><i class="fa-solid fa-trash"></i> Delete</button>`,
            class: '.deleteBtn'
        };
    }
}
