<template>
    <div class="container">
        <div class="row m-4 g-gray-900">

            <div class="col-md-4 my-3" v-for="(book, index) in books" :key="index">
                <div>
                    <ul class="list-group">
                        <li class="list-group-item">
                            NAME: {{ book.name }}
                        </li>
                        <li class="list-group-item"> AUTHORS: {{ book.authors }} </li>
                        <li class="list-group-item"> ISBN: {{ book.isbn }} </li>
                        <li class="list-group-item"> COUNTRY: {{ book.country }} </li>
                        <li class="list-group-item"> PUBLISHERS: {{ book.publisher }} </li>
                        <li class="list-group-item"> NUMBER OF PAGES: {{ book.number_of_pages }} </li>
                    </ul>
                </div>
                <div class="col-md-12 mt-2">
                    <div style="text-align: end;">
                        <a class="btn btn-success mx-1 btn-sm" :href="`/${book.id}`"> Edit </a>
                        <button class="btn btn-danger mx-1 btn-sm" @click="deletebook(book)"> Delete </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import swal from 'sweetalert';
    export default {
        mounted() {
            console.log('Component mounted.')
            this.loadbooks()
        },
        data: function () {
            return {
                books: []
            }
        },
        methods: {
            deletebook(id) {
                swal("Warning", `Are you sure you want to delete ${id.name}`, "warning").then((res) => {
                    if (res == true) {
                        axios.delete(`/api/v1/books/${id.id}`)
                        .then((response) => {
                            this.loadbooks()
                        })
                        .catch((err) => {
                            swal("Oop's", "An error has ocoured.", "error");
                        });   
                    }
                });
            },

            loadbooks() {
                axios.get('/api/v1/books')
                .then((res) => {
                    this.books = res.data.data
                    this.$toasted.show(`${res.data.message}`)
                })
                .catch((err) => {
                    swal("Oop's", "An error has ocoured.", "error");
                });
            }
        }
    }
</script>
