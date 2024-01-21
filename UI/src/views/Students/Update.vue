
<template>
  
  <div class = "container">
    <div class="card">
        <div class="card-header">
            <h4>Update Details</h4>
        </div>
        <div class="card-body">

            <ul class="alert alert-warning border-warning-subtle rounded-3" v-if="Object.keys(this.errorList || {}).length > 0">
                <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
                    {{ error[0] }}
                </li>
            </ul>
            <div class="mb-3">
                <label for="">Name</label>
                <input type="text" v-model="model.event.name" class="form-control" placeholder="Event Name e.g. 101 Anniversary" />
            </div>
            <div class="mb-3">
                <label for="">Gender</label>
                <br> <!-- This will create a line break -->
                <select v-model="model.event.gender" id="gender" name="gender">
                <option :value="null" disabled>Select Gender</option>
                <option value="M">M - Male</option>
                <option value="F">F - Female</option>
                </select>

            </div>
            <div class="mb-3">
                <label for="">Email;</label>
                <input type="text" v-model="model.event.email" class="form-control" placeholder="YYYY-MM-DD e.g. 2023-10-12"/>
            </div>
            <div class="mb-3">
                <label for="">Year Of Study</label>
                <br> <!-- This will create a line break -->
                <select v-model="model.event.yearOfStudy" id="yearOfStudy" name="yearOfStudy">
                <option :value="null" disabled>Select Year Of Study</option>
                <option value="1">1</option>
                <option value="2">2</option> 
                <option value="3">3</option>
                <option value="4">4</option>
                </select>

            </div>
            
            
            <div class="mb-3">
                <button type="button" @click="updateEvent" class="btn btn-success">Save</button>
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
                        slug:'',
                        startAt:'',
                        endAt:''
                    }
                }
            }
        },
        mounted(){
            //console.log("mounted 1" + this.$route.params.id)
            this.eventId = this.$route.params.id;
            //console.log("mounted 1" +this.eventId)
            this.getEventData(this.$route.params.id);
        },
        methods:{
            getEventData(eventId){
                
                //console.log("getEventData 1" +this.eventId)
                axios.get(`http://127.0.0.1:8000/api/v1/students/${eventId}`).then(res => {
                    //console.log(res.data)
                    
                    this.model.event.name = res.data.name
                    this.model.event.gender = res.data.gender
                    this.model.event.email = res.data.email
                    this.model.event.yearOfStudy = res.data.yearOfStudy
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

            updateEvent(eventId){
                var selfP = this;
                axios.patch(`http://127.0.0.1:8000/api/v1/students/${this.eventId}`,this.model.event).then(
                    res =>{
                        console.log(res.data)
                        alert(res.data.message);
                       
                        this.errorList = ''
                    })
                    .catch(function (error) {
                   
                    //console.log("errors -- " +error.response.data.errors);

                    if (error.response) {

                    if(error.response.status == 422){
                        console.log(error.response.data)
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
            }
        }


    }


    

</script>