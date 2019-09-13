<template>
    <div>
        <md-toolbar>
            <div class="md-toolbar-section-start">
                <h3 class="md-title" style="color: ghostwhite;">Ticket</h3>
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
                            <md-field :class="getValidationClass('nama')">
                                <label for="nama">Nama</label>
                                <md-input name="nama" id="nama" autocomplete="given-name" v-model="form.nama"
                                    :disabled="sending" />
                                <span class="md-error" v-if="!$v.form.nama.required">Silahkan masukan nama..</span>
                                <span class="md-error" v-else-if="!$v.form.nama.minLenght">Minimal masukan 3
                                    huruf..</span>
                            </md-field>
                        </div>
                    </div>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item">
                            <md-field :class="getValidationClass('kategori')">
                                <label for="kategori">Kategori</label>
                                <md-select name="kategori" id="kategori" v-model="form.kategori" md-dense
                                    :disabled="sending">
                                    <md-option></md-option>
                                    <md-option v-for="i in kategori_kat" :value="i.kategori_id"
                                        v-bind:key="i.kategori_id">
                                        {{ i.kategori_nama }}
                                    </md-option>
                                </md-select>
                                <span class="md-error" v-if="!$v.form.kategori.required">Silahkan masukan
                                    kategori..</span>
                            </md-field>
                        </div>
                    </div>
                    <div>
                    </div>
                    <md-field :class="getValidationClass('deskripsi')">
                        <label for="deskripsi">Deskripsi</label>
                        <md-textarea name="deskripsi" id="deskripsi" md-counter="150" v-model="form.deskripsi" :disabled="sending" />
                        <span class="md-error" v-if="!$v.form.deskripsi.required">Silahkan isi deskripsi..</span>
                        <span class="md-error" v-else-if="!$v.form.deskripsi.maxLenght">Maksimal masukan 150
                            huruf..</span>
                    </md-field>
                </md-card-content>
                <md-progress-bar md-mode="indeterminate" v-if="sending" />

                <md-card-actions>
                    <md-button type="submit" class="md-accent" :disabled="sending">Input</md-button>
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
          lb: String
      },
      mixins: [validationMixin],
      data: () => ({
          info: null,
          form: {
              nama: null,
              kategori: "",
              deskripsi: null,
          },
          userSaved: false,
          sending: false,
          lastUser: null
      }),
      computed: {
          ...mapState([
              'kategori_kat'
          ])
      },
      mounted() {
          this.getjsonData()
      },
      validations: {
          form: {
              nama: {
                  required,
                  minLength: minLength(3)
              },
              kategori: {
                  required
              },
              deskripsi: {
                  required,
                  maxLength: maxLength(150)
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
              this.form.nama = null
              this.form.kategori = null
              this.form.deskripsi = null
          },
          saveUser() {
              this.sending = true
              var n = `${this.form.nama}`
              var m = `${this.form.deskripsi}`
              var kat = `${this.form.kategori}`
              var post_req = '/api/ticket/?n=' + n + '&m=' + m + '&kat=' + kat
              // Instead of this timeout, here you can call your API
              axios
                  .post(post_req)
              window.setTimeout(() => {
                  this.lastUser = `${this.form.nama}`
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
          refresh() {
              this.$emit('refresh')
          },
          close() {
              this.$emit('close')
          },
          getjsonData(){
              this.kategori_kat = this.json
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