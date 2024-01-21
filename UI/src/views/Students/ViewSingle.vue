
<template>
  
  <div class = "container">
    <div class="card">
        <div class="card-header">
            <h4>View Student Details</h4>
        </div>
        <div class="card-body">

            <ul class="alert alert-warning border-warning-subtle rounded-3" v-if="Object.keys(this.errorList || {}).length > 0">
                <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
                    {{ error[0] }}
                </li>
            </ul>
            <div class="mb-3">
                <label for="">Name</label>
                <input type="text" disabled v-model="model.event.name" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="">Email</label>
                <input type="text" disabled v-model="model.event.email" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="">Gender</label>
                <input type="text" disabled v-model="model.event.gender" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="">Enrollment Index</label>
                <input type="text" disabled v-model="model.event.examno" class="form-control"/>
            </div>
            <div class="mb-3">
                <label for="">Year Of Study</label>
                <input type="text" disabled v-model="model.event.yearOfStudy" class="form-control"/>
            </div>
            
            
            <div class="mb-3">
               
                <RouterLink to="/" class="btn btn-secondary float-end"> Back </RouterLink>
            </div>




        </div>
    </div>
  </div>
  </template>
  

  <script>
  import axios from 'axios'
    export default{
        name: 'eventEdit',
        data(){
            return{
                eventId: '',
                errorList: null,
                model:{
                    event:{
                        name:'',
                        email:'',
                        yearOfStudy:'',
                        gender:''
                    }
                }
            }
        },
        mounted(){
//          console.log(this.$route.params.id)
            this.eventId = this.$route.params.id;
            this.getEventData(this.$route.params.id);
        },
        methods:{
            getEventData(eventId){
                axios.get(`http://127.0.0.1:8000/api/v1/students/${eventId}`).then(res => {
                    //console.log(res.data)
                    
                    this.model.event.name = res.data.name
                    this.model.event.email = res.data.email
                    this.model.event.examno = res.data.examno
                    this.model.event.yearOfStudy = res.data.yearOfStudy
                    this.model.event.gender = res.data.gender
                }).catch(function (error) {
                    //console.log("error -- " + error.response.data.error);

                    //console.log("errors -- " +error.response.data.errors);

                    if (error.response) {

                    if(error.response.status == 404){
                        alert(error.response.data.message);
                        selfP.errorList = error.response.data.error;
                    }
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.data);
                    // console.log(error.response.status);
                    // console.log(error.response.headers);
                    } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                    } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                    }
                });
            },
        }


    }


    

</script>