<template>
    <div class="field">
        <label class="label is-small" for="category">Category</label>
        <div class="control">
            <div class="select">
                <select name="category" required @change="loadProperties">
                    <option value="0"></option>
                    <slot name="select-options"></slot>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EntityProductCategories',

    data () {
        return {
            specifications: document.getElementById('specifications')
        }
    },

    methods: {
        loadProperties(event) {
            let el = event.currentTarget;
            
            axios.get('/admin/product/categories', {
                    params: {
                        selectValue: el.options[el.selectedIndex].value
                    }
                })
                .then(response => {
                    specifications.innerHTML = response.data;
                })
                .catch(error => {
                    specifications.innerHTML = '';
                });
        }
    }
}
</script>