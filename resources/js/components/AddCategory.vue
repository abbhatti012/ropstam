<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Category</h4>
                </div>
                <div class="card-body">
                    <br>
                    <div v-if="errors" class="bg-red text-white py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
                        <div v-for="(v, k) in errors" :key="k">
                            <li v-for="error in v" :key="error" class="text-sm">
                            {{ error }}
                            </li>
                        </div>
                    </div>
                    <form @submit.prevent="create">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" v-model="category.title">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" class="btn btn-primary"><span v-if="loading" class="spinner-border spinner-border-sm"></span> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    name:"add-category",
    data(){
        return{
            category:{
                title:"",
            },
            errors : null,
            loading : false,
        }
    },
    methods:{
        // create new category
        async create(){
            this.loading = true;
            await this.axios.post('/api/categories', this.category).then(response=>{
                if(response.status == 200) {
                    this.$router.push({name:"Dashboard"})
                }
                this.loading = false;
            }).catch(error=>{
                this.errors = error.response.data.errors;
                this.loading = false;
                console.log(error)
            })
        }
    }
}
</script>