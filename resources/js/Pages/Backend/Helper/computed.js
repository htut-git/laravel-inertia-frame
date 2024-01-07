import { computed } from "vue";

const baseComputed = {
    getFormType: (type) => computed(() => {
        if (type == 'email') {
            return type;
        }
        return 'text';
    })
}

export default baseComputed;
