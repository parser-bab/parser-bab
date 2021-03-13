<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Имя и фамилия
                <input type="text" class="form-control" v-model="title">
                <br>
                <div class="d-flex justify-content-center">
                    <button v-on:click="update" class="btn btn-primary">Получить</button>
                </div>
                <br>
                <table v-if="urldata.length != 0" class="table table-hover table-dark table-hover">
                    <thead>
                    <tr>
                        <th>Фото</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Группа</th>
                    </tr>
                    </thead>
                    <tbody class="sort">
                    <tr v-for="url in urldata">
                        <td><a :href="url.url" target="_blank">
                            <img :src="url.photo" class="rounded-circle" width="200"
                                 height="200">
                        </a></td>
                        <td>{{ url.first_name }}</td>
                        <td>{{ url.last_name }}</td>
                        <td v-for="group in url.groups">
                            <a :href="group.url_group">| {{group.title}} |</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data: function () {
        return {
            title: '',
            urldata: '',

            name: '',
            description: '',
            output: ''
        }
    },
    mounted() {

    },
    methods: {
        update: function (event) {
            // console.log(this.title)
            axios.post('/findgirl', {
                title: this.title,
            }).then((response) => {
                this.urldata = response.data
            })
            console.log(this.urldata);
        },

        // formSubmit: function (event) {
        //     axios.post('/apidata', {
        //         name: this.name,
        //         description: this.description
        //     }).then((response) => {
        //         console.log (response)
        //     })
        // },


    }
}
</script>
