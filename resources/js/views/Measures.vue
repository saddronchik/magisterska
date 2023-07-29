<template>
    <div>
        <Navbar @click="isOpen = !isOpen" />
        <Sidenav v-model="isOpen" />

        <section class="main">
            <div class="container">
                <h5 class="title">Список ответов на обращения</h5>
                <div class="sortings">

                </div>
                <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet"/>
                <div class="row">
                    <ul class="collapsible" ref="collapsible">
                        <li v-for="measure in measures" :key="measure.id">
                            <div class="collapsible-header">
                                <div class="collapsible-header__inner">
                                    <div class="header__inner-left">
                                        <i class="material-icons"></i>ID{{ measure.id }}
                                        <i class="material-icons">person</i>{{ measure.text }}
                                    </div>

                                    <div class="header__inner-right">
                                        <i class="material-icons">event</i>{{ measure.created_at.substring(0,10) }}
                                    </div>

                                </div>
                            </div>
                            <div class="collapsible-body">
                                <div class="collapsible-body_top">
                                    <div class="top_left">
                                        ФИО заявителя: <span>{{ measure.FIO }}</span> <br>
                                        Статус: <span> {{ measure.status }} </span>
                                    </div>
                                    <div class="top-right">
                                        Дата
                                        <span class="date-ref">{{ measure.created_at.substring(0,10) }}</span>
                                    </div>
                                </div>

                                <div class="collapsible-body-content">
                                    <div class="content-center">
                                        <p class="text-ref">
                                            Текст обращения <span> {{ measure.textObr }} </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="collapsible-body-footer">
                                    <div class="footer-left">
                                        <div class="user-email">
                                            Эл.адрес &nbsp; <span>{{ measure.email }}</span>
                                        </div>
                                        <div class="user-phone">
                                            Контактный тел.&nbsp;
                                            <span> {{ measure.telephone }}</span>
                                        </div>
                                    </div>
                                    <div class="footer-right">
                                        <button class="btn modal-trigger" value="" ref="modalReply" href="#modal3" ><i class="material-icons right">reply</i>Редактировать</button>
<!--                                    <a class="btn" v-bind:href="'api/showMesures/'+ measure.id"><i class="material-icons right">reply</i>Редактировать</a>-->

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Модальное окно с формой newDepartment -->
        <div id="modal3" class="modal" ref="modalReply">

            <div class="modal-content">
                <div class="modal-close right-align">
                    <i class="material-icons">close</i>
                </div>

                <div class="container">
                    <div class="col s12 center-align">
                        <p class="section__title section__title-form">
                           Редактировать ответ
                        </p>
                    </div>

                    <form class="addMesarues">
                        <div class="row">
                            <div class="input-field col s12">
                                <span></span>
                                <input type="number" id="id" v-model="id">
                                <label for="id">Введите id ответа</label>


                            </div>
                            <div class="input-field col s12">
                                <span></span>
                                <input type="text" id="text" v-model="text">
                                <label for="text">Введите новый текст ответа</label>
                            </div>
                            <div class="input-field col s12">
<!--                                <span></span>-->
<!--                                <input type="text" id="status" v-model="text">-->
<!--                                <label for="status">Введите новый статус обращения</label>-->
                                <p>Выберите новый статус обращения</p>
                                <!--                            <input type="text" name="role" id="role" v-model.trim="role">-->
                                <!--                            <label for="role">Роль пользователя</label>-->
                                <input type="radio" id="one" value="Обработано" v-model="picked" v-model.trim="status">
                                <label for="one">Обработано</label>
                                <br>
                                <input type="radio" id="two" value="Не обработан" v-model="picked" v-model.trim="status">
                                <label for="two">Не обработан</label>
                                <br>
                                <input type="radio" id="three" value="Отклонено" v-model="picked" v-model.trim="status">
                                <label for="three">Отклонено</label>
                                <br>
                                <input type="radio" id="four" value="В обработке" v-model="picked" v-model.trim="status">
                                <label for="four">В обработке</label>
                            </div>
                        </div>

                        <div class="row">
                            <button class="btn" type="submit" @click.prevent="updateMesarues">Обновить</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



</template>

<script>
import M from "materialize-css";
import axios from "axios";
import Navbar from "../components/app/AdminNavbar";
import Sidenav from "../components/app/Sidenav";

export default {
    components: {
        Navbar,
        Sidenav,
    },

    data: () => ({
        isOpen: true,
        collapsible: null,
        errors: false,
        measures: "",
        dropdown2: null,
        userInfo: "",
        reply: "",
        id:"",
        text:"",
        status:"",
        picked:[],
        modalReply: null,
    }),

    filters: {

    },

    methods: {
        getData() {
            console.log(this.references);
        },

        dropActions() {
            this.drop = M.Dropdown.init(this.$refs.drop, {constrainWidth: false});
        },

        updateMesarues() {
            axios.post('/api/measuresUpdate', {
                    id: this.id,
                    text: this.text,
                    status: this.status,
                },
                {
                    headers: {"Content-type": "application/json"}
                })
                .then(res => {
                    if (res.data.status) {
                        // let instance = M.Modal.getInstance(this.$refs.modal);
                        // instance.close();
                        this.$message('Ответ обновлен!');
                    }
                })

                .catch(err => {
                    console.log(err.response.data);
                })
        },
    },

    mounted() {
        axios
            .get("/api/measuresIndex")
            .then((response) => (this.measures = response.data))
            .catch((error) => {
                console.log(error);
                this.errors = true;
            });

        this.collapsible = M.Collapsible.init(this.$refs.collapsible, {});
        this.dropdown2 = M.Dropdown.init(this.$refs.dropdown, {
            constrainWidth: false
        })
        this.modalReply = M.Modal.init(this.$refs.modalReply, {});
        this.userInfo = JSON.parse(localStorage.getItem('userInfo'));
    },
};
</script>

<style>
@import "/assets/css/index.css";

.main {
    margin-top: 100px;
}

.collapsible-header__inner {
    width: 100%;
    display: flex;
    justify-content: space-between;
}

.collapsible-body_top,
.collapsible-body-footer {
    display: flex;
    justify-content: space-between;
    color: #000;
    font-size: 12px;
    font-weight: bold;
}

.collapsible-body_top span {
    color: rgb(158, 152, 152);
}

.content-center {
    padding: 5px 0;
    font-weight: bold;
}

.text-ref span {
    font-weight: normal;
}

.footer-left span {
    font-weight: normal;
}

.user-email,
.user-phone {
    font-weight: bold;
    font-size: 12px;
}
</style>
