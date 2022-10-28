<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Car</h4>
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
                                    <label>Category</label>
                                    <select class="form-control" v-model="car.category" name="" id="">
                                        <option v-for="category in categories" :value="category.id">{{ category.title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="car.name">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="text" class="form-control" v-model="car.color">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" class="form-control" v-model="car.model">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Make</label>
                                    <input type="text" class="form-control" v-model="car.make">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Registration Number</label>
                                    <input type="text" class="form-control" v-model="car.registration_number">
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
            car:{
                name:"",
                color:"",
                model:"",
                make:"",
                registration_number:"",
                category: ""
            },
            errors : null,
            loading : false,
            categories: []
        }
    },
    mounted() {
        this.getCategories();
        this.getData();
    },
    methods:{
        async create(){
            this.loading = true;
            await this.axios.put('/api/cars/'+this.$route.params.id, this.car).then(response=>{
                if(response.status == 200) {
                    this.$router.push({name:"Dashboard"})
                }
                this.loading = false;
            }).catch(error=>{
                this.errors = error.response.data.errors;
                this.loading = false;
                console.log(error)
            })
        },
        async getCategories(){
            await this.axios.get('/api/categories').then(response=>{
                if(response.status == 200) {
                    this.categories = response.data.data
                }
            }).catch(error=>{
                
            })
        },
        async getData(){
            await this.axios.get(`/api/cars/${this.$route.params.id}`).then(response=>{
                if(response.status == 200) {
                    this.car = response.data.data
                    this.car.category = response.data.data.cat_id
                }
            }).catch(error=>{
                
            })
        }
    }
}
</script>