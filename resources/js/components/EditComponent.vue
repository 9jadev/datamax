<template>
    <div class="container">
        <div class="m-4">
            <a class="btn btn-success mx-1 btn-sm" style="text-align: right;" href="/"> Back </a>
        </div>
        <div class="row g-gray-900 card m-4">
           
            <form class="p-3" @submit.prevent="updatebook">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" v-model="book.name" class="form-control" id="name" required/>
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">Isbn</label>
                    <input type="text" v-model="book.isbn" class="form-control" id="isbn" required/>
                </div>
                <div class="mb-3">
                    <label for="Author" class="form-label">Authors</label>
                    <input type="text" v-model="book.authors" class="form-control" id="authors" required/>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" v-model="book.country" class="form-control" id="country" required/>
                </div>

                <div class="mb-3">
                    <label for="publisher" class="form-label">Publisher</label>
                    <input type="text" v-model="book.publisher" class="form-control" id="publisher" required/>
                </div>

                <div class="mb-3">
                    <label for="number_of_pages" class="form-label">Number of pages</label>
                    <input type="text" v-model="book.number_of_pages" class="form-control" id="number_of_pages" required/>
                </div>

                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date</label>
                    <input type="text" v-model="book.release_date" class="form-control" id="release_date" required/>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import swal from 'sweetalert';
export default {
    props: {
        id: {
        type: Number,
        required: true
      }
    },
    mounted() {
        this.getsingle()
    },
    data () {
        return {
            book: null
        }
    },

    methods: {
        updatebook() {
            axios.patch(`/api/v1/books/${this.id}`, this.book).then((res) => {
                this.$toasted.show(`${res.data.message}`);
            });
        },
        getsingle () {
            axios.get(`/api/v1/books/${this.id}`)
            .then((res) => {
                this.book = res.data.book
                this.$toasted.show(`${res.data.message}`)
            })
            .catch((err) => {
                swal("Oop's", "An error has ocoured.", "error");
            });
        }
    }
}
</script>