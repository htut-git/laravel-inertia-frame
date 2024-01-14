export default class ActionBtn {
    constructor() { }
    static editBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none
            focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-3 py-2  text-center me-2 mb-2
            dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 editBtn">
            <i class="fa-solid fa-pen-to-square"></i> Edit</button>`,
            class: '.editBtn'
        };
    }

    static deleteBtn(dataId) {
        return {
            html: `<button data-id="${dataId}"  class="text-white bg-red-700 hover:bg-red-800 focus:outline-none
            focus:ring-4 focus:ring-red-300 font-medium rounded-full
            text-sm px-3 py-2 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900
            deleteBtn"><i class="fa-solid fa-trash"></i> Delete</button>`,
            class: '.deleteBtn'
        };
    }
}
