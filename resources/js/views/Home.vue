<template>
  <div class="app">
    <Navbar />

    <div class="app-content">
      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col s12 center-align">
            </div>
            <div class="col s4 left-content">
              <h3 class="main-title">Направление замечаний и предложений</h3>
              <p>Данный раздел на ведомственном сайте создан для направления гражданами замечаний и предложений.</p>
              <p>Нажмите на кнопку "Отправить заявку" и заполните все данные в появившейя форме.</p>
            </div>
            <div class="col s8 right-content hide-on-med-and-down">
              <img
                src="/assets/img/second-bg.jpg"
                alt="main bg"
                width="100%"
                height=""
              />
            </div>
          </div>

          <div class="row">
            <div class="secttion__footer center-align">
              <button data-target="modal1" class="btn-large z-depth-4 purple lighten-2 modal-trigger open-btn">
                Отправить заявку
              </button>
            </div>
          </div>
        </div>
      </section>

        <div class="divider"></div>
         <section class="contact-info" id="contact">
           <div class="container">
             <div class="row">

             </div>
             <div class="row">
               <div class="col s8">
                 <img src="/assets/img/main-bg.jpg" alt="info" width="100%">
               </div>
               <div class="col s4 contact-info-text">
                 <h4 class="contact-title center-align">Контактная информация</h4>
                 <p><span>Адрес&nbsp;</span>город Донецк, улица Артема, д. 157, 283048</p>
                 <p><span>Email&nbsp;</span>minjust@minjust-dnr.ru</p>
                 <p><span>График работы:&nbsp;</span>Понедельник-четверг с 9:00 до 18:00, пятница с 9:00 до 16:45.
                    Перерыв с 13:00 до 13:45. Суббота-воскресенье — выходные дни.</p><br>
                 <span></span>
               </div>
             </div>
           </div>
         </section>

      <!-- Модальное окно с формой -->
      <div id="modal1" class="modal" ref="modal">
        <div class="modal-content">
          <div class="modal-close right-align">
            <i class="material-icons">close</i>
          </div>

          <section class="contact-form">
            <div class="container">
              <div class="col s12 center-align">
                <p class="section__title section__title-form">
                  Заполните форму для отправки обращения
                </p>
              </div>

              <div class="contact-form__inner">
                <div class="row">
                  <form class="col s12" @submit.prevent="submitForm">
                    <div class="row">
                      <div class="input-field col s4">
                        <input
                          id="first_name"
                          type="text"
                          v-model.trim="firstName"
                          :class="{
                            invalid:
                              ($v.firstName.$dirty && !$v.firstName.required) ||
                              ($v.firstName.$dirty && !$v.firstName.minLength),
                          }"
                        />
                        <label for="first_name">Фамилия</label>
                        <small
                          class="helper-text invalid"
                          v-if="$v.firstName.$dirty && !$v.firstName.required"
                        >
                          Заполните поле
                        </small>
                      </div>
                      <div class="input-field col s4">
                        <input
                          id="last_name"
                          type="text"
                          v-model.trim="lastName"
                          :class="{
                            invalid:
                              ($v.lastName.$dirty && !$v.lastName.required) ||
                              ($v.lastName.$dirty && !$v.lastName.minLength),
                          }"
                        />
                        <label for="last_name">Имя</label>
                        <small
                          class="helper-text invalid"
                          v-if="$v.lastName.$dirty && !$v.lastName.required"
                        >
                          Заполните поле
                        </small>
                      </div>
                      <div class="input-field col s4">
                        <input
                          id="middle_name"
                          type="text"
                          v-model.trim="middleName"
                          :class="{
                            invalid:
                              ($v.middleName.$dirty &&
                                !$v.middleName.required) ||
                              ($v.middleName.$dirty &&
                                !$v.middleName.minLength),
                          }"
                        />
                        <label for="middle_name">Отчество</label>
                        <small
                          class="helper-text invalid"
                          v-if="$v.middleName.$dirty && !$v.middleName.required"
                        >
                          Заполните поле
                        </small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s8">
                        <input
                          type="email"
                          name="email"
                          id="email"
                          v-model.trim="email"
                          :class="{
                            invalid:
                              ($v.email.$dirty && !$v.email.required) ||
                              ($v.email.$dirty && !$v.email.email),
                          }"
                        />
                        <label for="email">Адрес электронной почты</label>
                        <small
                          class="helper-text invalid"
                          v-if="$v.email.$dirty && !$v.email.required"
                        >
                          Поле не должно быть пустым
                        </small>
                        <small
                          class="helper-text invalid"
                          v-else-if="$v.email.$dirty && !$v.email.email"
                        >
                          Некорректный адрес эл почты
                        </small>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s6">
                          <input type="text" name="telephone" id="telephone" v-model="telephone">
                        <label for="telephone">Номер телефона</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s8">
                        <select ref="select" v-model="issue_select">
                          <option value="" disabled selected>
                            Выберите причину обращения
                          </option>
                          <option
                            v-for="issue in issues"
                            :key="issue.issue"
                            :value="issue.issue"
                          >
                            {{ issue.issue }}
                          </option>
                        </select>
                        <label>Причина обращения</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">


                        <select
                          ref="select2"
                          v-model="select2"
                        >
                          <optgroup
                            v-for="department in deps"
                            :key="department.id"
                            :label="department.nameOtdel"
                          >

                            <option
                              v-for="{
                                NamePodrazdel,
                                id,
                              } in department.NamePodrazdel"
                              :key="id"
                              :value="department.id"
                            >
                              {{ NamePodrazdel }}
                            </option>
                          </optgroup>
                        </select>
                        <label>Структурное подразделение</label>
                      </div>
                    </div>

                    <div class="row">
                      <form class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <textarea
                              id="textarea1"
                              class="materialize-textarea"
                              v-model="note"
                            ></textarea>
                            <label for="textarea1">Текст обращения</label>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="row">
                      <div class="form-actions">
                        <button type="submit" class="btn z-depth-3 purple lighten-2" @click.prevent="sendReferense">Отправить</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import store from '../store';
import M from "materialize-css";
import Navbar from "../components/app/Navbar";
import Modal from "../components/app/Modal";
import { email, required, minLength } from "vuelidate/lib/validators";

export default {
  name: "Home",
  components: {
    Navbar,
    Modal,
  },

  data: () => ({
    modal: null,
    firstName: "",
    lastName: "",
    middleName: "",
    email: "",
    telephone: "",
    issue_select: "",
    depart_select: "",
    note: "",

    select: null,
    select2: '',
    value: 1,
    issues: [
      { issue: "Замечание по работе", value: "" },
      { issue: "Некомпетентность сотрудника", value: "" },
      { issue: "Оскорбительное поведение", value: "" },
      { issue: "Превышение полномочий", value: "" },
    ],
    // departments: null,
    deps: [
      {id: 1, nameOtdel: "По умолчанию", NamePodrazdel: [
        {id: 0, NamePodrazdel: "На усмотрение персонала"}
      ] },
      {id: 2, nameOtdel: "Центральный аппарат Министерства юстиции", NamePodrazdel: [
        {id: 1, NamePodrazdel: "Отдел приема документов"},
        {id: 2, NamePodrazdel: "Отдел обработки документов"},
        {id: 3, NamePodrazdel: "Отдел сбора информации"},
        // {id: 4, NamePodrazdel: "Отдел записи актов гражданского состояния"},
        // {id: 5, NamePodrazdel: "Отдел государственной регистрации вещных прав"},
        // {id: 6, NamePodrazdel: "Отдел государственной исполнительной службы"},
        // {id: 7, NamePodrazdel: "Отдел технической инвентаризации, учета и оценки н"},
      ]},
      {id: 3, nameOtdel: "Территориальные ограны", NamePodrazdel: [
        {id: 8, NamePodrazdel: "Донецкий городской отдел ЗАГС"},
        {id: 9, NamePodrazdel: "Макеевский городской отдел ЗАГС"},
        // {id: 10, NamePodrazdel: "Енакиевский городской отдел ЗАГС"},
        // {id: 11, NamePodrazdel: "Горловский городской отдел ЗАГС"},
        // {id: 12, NamePodrazdel: "Харцызский городской отдел ЗАГС"},
      ]},
      {id: 4, nameOtdel: "Государственный нотариальный архив", NamePodrazdel: [
        {id: 13, NamePodrazdel: "Государственная нотариальная контора города Донецк"},
        {id: 14, NamePodrazdel: "Государственная нотариальная контора города Харцызск"},
        // {id: 15, NamePodrazdel: "осударственная нотариальная контора города Снежное"},
        // {id: 16, NamePodrazdel: "Государственная нотариальная контора города Макеевка"},
        // {id: 17, NamePodrazdel: "Государственная нотариальная контора пгт Старобешево"},
        // {id: 18, NamePodrazdel: "Государственная нотариальная контора города Ясиноватая"},
        // {id: 19, NamePodrazdel: "Государственная нотариальная контора города Новоазовск"},
      ]},
    ]
  }),

  validations: {
    firstName: { required, minLength: minLength(2) },
    lastName: { required, minLength: minLength(6) },
    middleName: { required, minLength: minLength(6) },
    email: { email, required },
  },

  methods: {
    sendReferense() {
      if (this.$v.$invalid) {
        this.$v.$touch();
        return;
      }

      axios.post('api/references',{
          FIO: this.firstName + ' ' + this.lastName + ' ' + this.middleName,
          email:this.email,
          telephone: this.telephone,
          prichinaObr: this.issue_select,
          textObr: this.note,
          idPodr: this.select2
        },
        { headers: {
          "Content-type": "application/json"
        }
      })
      .then(res => {
        if (res.data.status) {
           let instance = M.Modal.getInstance(this.$refs.modal);
           instance.close();
           this.$message('Обращение успешно отправлено!');
        }
      })

      .catch(err => {
        console.log(err.response.data);
        this.error = true;
      })
    }
    // async submitForm() {
    //   if (this.$v.$invalid) {
    //     this.$v.$touch();
    //     return;
    //   }

    //   const formData = {
    //     // userId: Math.floor(Math.random() * 10),
    //     FIO: this.firstName + " " + this.lastName + " " + this.middleName,
    //     email: this.email,
    //     telephone: this.telephone,
    //     prichinaObr: this.issue_select,
    //     idPodr: this.select2,
    //     textObr: this.note,
    //   };

    //   try {
    //       await this.$store.dispatch('sendReference', formData)
    //       // this.$router.push('/admin')
    //   } catch(e) {
    //     console.log(e);
    //   }

    // },
  },

  mounted() {
    // axios
    //   .get("http://127.0.0.1:8000/api/podrazdel")
    //   .then((response) => (this.departments = response.data.podrazdels));

    this.modal = M.Modal.init(this.$refs.modal, {});
    this.select = M.FormSelect.init(this.$refs.select, {});
    this.select2 = M.FormSelect.init(this.$refs.select2, {});

    // this.$error("TODO: Отформатировать дату на бекенде, сделать сортировки на фронте");
  },
};
</script>

<style scoped>
.app-content {
  height: 90vh;
  margin-top: 100px;
}

.main-title,
.contact-title {
  font-weight: 800;
}

.left-content p {
  font-size: 21px;
}

.section__title-form {
  font-weight: bold;
  margin-bottom: 30px;
}

.secttion__footer {
  margin-top: 100px;
}


.contact-info {
  margin-top: 100px;
}

.contact-title {
  margin-bottom: 50px;
}

.contact-info-text span {
  font-weight: bold;
}
</style>
