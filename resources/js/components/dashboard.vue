<template>
    <div>
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-12 mb-2 text-end">
                <router-link :to='{name:"add-category"}' class="btn btn-primary">Add Category</router-link>
                <router-link :to='{name:"add-car"}' class="btn btn-primary">Add Car</router-link>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cars</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Color</th>
                                        <th>Make</th>
                                        <th>Model</th>
                                        <th>Registration Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody v-if="cars.length > 0">
                                    <tr v-for="(car,key) in cars" :key="key">
                                        <td>{{ car.id }}</td>
                                        <td>{{ car.name }}</td>
                                        <td>{{ car.category.title }}</td>
                                        <td>{{ car.color }}</td>
                                        <td>{{ car.make }}</td>
                                        <td>{{ car.model }}</td>
                                        <td>{{ car.registration_number }}</td>
                                        <td>
                                            <router-link :to="'/car-edit/' + car.id" class="btn btn-success">Edit</router-link>
                                            <a href="javascript:void(0)" @click="deleteCar(car.id)" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="4" align="center">No cars Found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"cars",
    data(){
        return{
            cars:[]
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        // get all cars
        async getData(){
            await this.axios.get('/api/cars').then(response=>{
                this.cars = response.data.data
            }).catch(error=>{
                console.log(error)
                this.cars = []
            })
        },
        // delete car
        deleteCar(id){
            if(confirm("Are you sure to delete the car?")){
                this.axios.delete('/api/cars/'+id).then(response=>{
                    this.getData()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
}
</script>