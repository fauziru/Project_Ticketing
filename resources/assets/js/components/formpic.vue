<template>
    <div>
        <md-toolbar>
            <div class="md-toolbar-section-start">
                <h3 class="md-title" style="color: ghostwhite;">No. Ticket {{ req_id }}</h3>
            </div>
            <div class="md-toolbar-section-end">
                <md-button class="md-icon-button md-accent" @click="close()">
                    <md-icon style="color: ghostwhite">close</md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <form novalidate class="md-layout md-gutter" @submit.prevent="validateUser">
            <md-card class="md-layout-item">
                <md-card-header>
                    <div class="md-title md-alignment-center">{{ lb }}</div>
                </md-card-header>

                <md-card-content>
                    

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item">
                            <md-field :class="getValidationClass('pic')">
                                <label for="pic">Person in Charge</label>
                                <md-select name="pic" id="pic" v-model="form.pic" md-dense
                                    :disabled="sending">
                                    <md-option></md-option>
                                    <md-option v-for="i in pic_js" :value="i.pic_id"
                                        v-bind:key="i.pic_id">
                                        {{ i.pic_nama }} - {{ i.pic_divisi }}
                                    </md-option>
                                </md-select>
                                <span class="md-error" v-if="!$v.form.pic.required">Silahkan pilih PIC..</span>
                            </md-field>
                        </div>
                    </div>
                    <div class="md-layout md-gutter">
                        <div class="md-layout-item">
                            <md-field :class="getValidationClass('prioritas')">
                                <label for="prioritas">Prioritas</label>
                                <md-select name="prioritas" id="prioritas" v-model="form.prioritas" md-dense
                                    :disabled="sending">
                                    <md-option></md-option>
                                    <md-option v-for="i in prio_js" :value="i.prioritas_id"
                                        v-bind:key="i.prioritas_id">
                                        {{ i.prioritas_nama }}
                                    </md-option>
                                </md-select>
                                <span class="md-error" v-if="!$v.form.prioritas.required">Silahkan pilih prioritas..</span>
                            </md-field>
                        </div>
                    </div>
                </md-card-content>
                <md-progress-bar md-mode="indeterminate" v-if="sending" />

                <md-card-actions>
                    <md-button type="submit" class="md-accent" :disabled="sending">Perbarui</md-button>
                </md-card-actions>
            </md-card>
            <md-snackbar :md-active.sync="userSaved" style="align: center;"> {{ lastUser }}, Tiketmu berhasil diterima
            </md-snackbar>
        </form>

    </div>
</template>

<script>
  import axios from 'axios'
  import {
      validationMixin
  } from 'vuelidate'
  import {
      required,
      minLength,
      maxLength
  } from 'vuelidate/lib/validators'
  import { mapState, mapActions } from 'vuex'

  export default {
      name: 'formticket',
      props: {
          lb: String,
          req_id: Number
      },
      watch:{
        visibility (v) {
          this.showDialog = v
        }
      },
      mixins: [validationMixin],
      data: () =>({
        info: null,
        form: {
            pic: "",
            prioritas: "",
        },
        userSaved: false,
        sending: false,
        lastUser: null,
          }),
      computed: {
          ...mapState([
            'prio_js',
            'pic_js'
          ])
      },
      created() {
        this.getjsonData()
      },
      validations: {
              form: {
                  pic: {
                      required
                  },
                  prioritas: {
                      required
                  }
              }
          },
          methods: {
              getValidationClass(fieldName) {
                  const field = this.$v.form[fieldName]
                  if (field) {
                      return {
                          'md-invalid': field.$invalid && field.$dirty
                      }
                  }
              },
              clearForm() {
                  this.$v.$reset()
                  this.form.pic = null
                  this.form.prioritas = null
              },
              saveUser() {
                  this.sending = true
                  var id = `${this.req_id}`
                  var pic = `${this.form.pic}`
                  var pri = `${this.form.prioritas}`
                  var a
                  var put_req = '/api/ticket/'+ id +'?val_pic=' + pic +'&val_prioritas=' + pri 
                  // Instead of this timeout, here you can call your API
                  axios
                    .put(put_req)
                    .then(response =>(this.a = response.data.message))
                  window.setTimeout(() => {
                      this.userSaved = true
                      this.sending = false
                      this.clearForm()
                      this.close()
                      this.refresh()
                  }, 1500)
              },
              validateUser() {
                  this.$v.$touch()
                  if (!this.$v.$invalid) {
                      this.saveUser()
                  }
              },
              refresh(){
                  this.$emit('refresh')
              },
              close(){
                this.$emit('close')
              },
              getjsonData(){
                  this.pic_js = this.jsonpic
                  this.prioritas_js = this.jsonprio
              }
          }
  }
</script>

<style lang="scss" scoped>
  @import "~vue-material/dist/theme/engine"; // Import the theme engine

    @include md-register-theme("default", (
        primary: #0a3d62, // The primary color of your brand
        accent: #b71540 // The secondary color of your brand
    ));

    @import "~vue-material/dist/theme/all"; // Apply the theme
  .md-progress-bar {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
  }
  .md-dialog {
        min-width: 40vw;
    }

    small {
        display: blok;
    }

    .md-dialog {
        max-width: 768px;
    }

    .md-toolbar.md-theme-default {
        background-color: #3c6382;
    }

    .md-toolbar.md-theme-default.md-transparent {
        background-color: #3c6382;
    }

    .f-w {
        color: #ffffff;
    }
</style>