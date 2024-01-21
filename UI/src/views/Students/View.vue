
<template>
   <div class = "container">
   <div class="card">
      <div class="card-header">
          <h4>
            Attendance List
            <RouterLink to="/students/create" class="btn btn-primary float-end"> Enroll New Student</RouterLink>
          </h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover table-striped ">
          <thead>
            <tr>
              <th>sNo</th>
              <th>Name</th>
              <th>Enrollment Index</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="this.students.length > 0">
            
            <tr v-for="(student, index) in this.students" :key="index" @click="goToDetails(student.id)">
              <td>{{index + 1}}</td>
              <td>{{ student.name }}</td>
              <td>{{ student.examno }}</td>
             

              <td :class="{ 'status-green': student.status === 'TRUE', 'status-orange': student.status === 'FALSE' }">
                  <!-- Display check icon for 'TRUE' and cross icon for 'FALSE' -->
                  <span v-if="student.status === 'TRUE'">&#10004;</span>
                  <span v-else-if="student.status === 'FALSE'">&#10008;</span>
                 
              </td>

              <!-- action col not-->
              <td @click.stop>
                <Button  @click="deleteEvent(student.id)" class="btn btn-danger float-end"> Delete </Button>
                
                <RouterLink :to="{ path : '/students/' + student.id + '/edit'}" class="btn btn-success float-end"> Edit </RouterLink>
              </td>
            </tr>
           
          </tbody>
          
          <tbody v-else>
              <tr>
                <td colspan="6" > Loading ... </td>
              </tr>
          </tbody>
        </table>

        <div>
         

          <nav>
          <ul class="pagination">
            <li v-for="page in pages" :key="page" :class="{ 'active': page === currentPage }">
              <a class="page-link" @click.prevent="goToPage(page)" href="#">{{ page }}</a>
            </li>
          </ul>
          </nav>
        </div>

      </div>
   </div>
  </div>


  </template>
  
  

  <script>
// call laravel api to get event recs
import axios from 'axios'



export default{
  name: 'students',
  data(){
    return {
      students: [],
      itemsPerPage: 0,
      currentPage: 0,
      totalPages: 0
    }
  },
  created() {
    // Fetch initial data when the component is created
    this.getEvents(this.currentPage);

    // Set up auto-refresh every 5 seconds (adjust the interval as needed)
    this.refreshInterval = setInterval(() => {
      this.getEvents(this.currentPage);
    }, 5000);
  },
  computed: {
    totalPages() {
      return Math.ceil(this.students.length / this.itemsPerPage);
    },
    paginatedData() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.students.slice(start, end);
    },
    pages() {
      return Array.from({ length: this.totalPages }, (_, index) => index + 1);
    },
  },
  methods:{
    getEvents(page){
      axios.get(`http://127.0.0.1:8000/api/v1/students?page=${page}`).then(res => {

        console.log(res)

        this.students = res.data.data
        this.currentPage = res.data.current_page
        this.totalPages = res.data.last_page
        this.total = res.data.total - 1
        // this.last_page = res.data.last_page



        //console.log(this.events)
      });
    },
    deleteEvent(eventId){
      //console.log(eventId)

      if(confirm('Confirm to delete this record')){
        axios.delete(`http://127.0.0.1:8000/api/v1/students/${eventId}`).then(res => {
          console.log("Successfully deleted ");


          console.log("this.total remainder: " + this.total % 6);
          //if delete last item at last page then goto second last page
          if(this.currentPage == this.totalPages && this.total % 6 == 0){

            console.log("del event currentPage :" + this.currentPage);
            console.log("del event totalPages - 1:" + this.totalPages);
            this.getEvents(this.currentPage - 1);
          }
          else{
            this.getEvents(this.currentPage);
          }
          
        });
      }
    },
    goToPage(page) {
      this.currentPage = page;
      this.getEvents(this.currentPage);
    },
    goToDetails(id) {
      this.$router.push({ name: 'studentViewSingle', params: { id } });
    },
  },
}

  </script>

<style scoped>
/* component styles */
.status-green {
    background-color: #8eff8e; /* Green background color */
  }
  
.status-orange {
background-color: #ffa07a; /* Orange background color */
}
</style>