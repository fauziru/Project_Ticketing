<template>
    <div class="md-scrollbar">
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
        <md-card class="md-layout-item">
            <md-card-header>
                <div class="md-title md-layout md-alignment-center">
                    <div>
                        {{ lb }}
                    </div>
                    <div>
                        <md-button :disabled="tidakaktif(form.status)" class="md-icon-button md-accent"
                            @click="switchidup(true)" v-if="editstat">
                            <md-icon :style="dis(form.status)">edit</md-icon>
                            <md-tooltip md-direction="right">Edit</md-tooltip>
                        </md-button>
                        <md-button class="md-icon-button md-accent" @click="switchmati(false)" v-if="btsimpan">
                            <md-icon style="color: #78e08f">done</md-icon>
                            <md-tooltip md-direction="right">Simpan</md-tooltip>
                        </md-button>
                    </div>
                </div>
            </md-card-header>
            <md-card-content>
                <md-field>
                    <label for="nama">Pengirim</label>
                    <md-input name="nama" id="nama" v-model="form.nama" :disabled="editstat" />
                </md-field>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item">
                        <md-field>
                            <label for="prioritas">Prioritas</label>
                            <md-select name="prioritas" id="prioritas" v-model="form.prioritas" md-dense
                                :disabled="editstat">
                                <md-option></md-option>
                                <md-option v-for="i in prio_js" :value="i.prioritas_id" v-bind:key="i.prioritas_id">
                                    {{ i.prioritas_nama }}
                                </md-option>
                            </md-select>
                            <span class="md-error" v-if="!$v.form.prioritas.required">Silahkan masukan
                                kategori..</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="pic">PIC - Divisi</label>
                            <md-select name="pic" id="pic" v-model="form.pic" md-dense
                                :disabled="editstat">
                                <md-option></md-option>
                                <md-option v-for="i in pic_js" :value="i.pic_id" v-bind:key="i.pic_id">
                                    {{ i.pic_nama }} - {{ i.pic_divisi }}
                                </md-option>
                            </md-select>
                            <span class="md-error" v-if="!$v.form.pic.required">Silahkan masukan
                                kategori..</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item">
                        <md-field>
                            <label for="kategori">Kategori</label>
                            <md-select name="kategori" id="kategori" v-model="form.kategori" md-dense
                                :disabled="editstat">
                                <md-option></md-option>
                                <md-option v-for="i in kategori_kat" :value="i.kategori_id" v-bind:key="i.kategori_id">
                                    {{ i.kategori_nama }}
                                </md-option>
                            </md-select>
                            <span class="md-error" v-if="!$v.form.kategori.required">Silahkan masukan
                                kategori..</span>
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="status">Status</label>
                            <md-select name="status" id="status" v-model="form.status" md-dense
                                :disabled="editstat">
                                <md-option></md-option>
                                <md-option v-for="i in stat_js" :value="i.stat_id" v-bind:key="i.stat_id">
                                    {{ i.stat_nama }}
                                </md-option>
                            </md-select>
                            <span class="md-error" v-if="!$v.form.status.required">Silahkan masukan
                                kategori..</span>
                        </md-field>
                    </div>
                </div>

                <div class="md-layout md-gutter">
                    <div class="md-layout-item">
                        <md-field>
                            <label for="dibuat">Dibuat</label>
                            <md-input name="dibuat" id="dibuat" v-model="form.dibuat" :disabled="true" />
                        </md-field>
                    </div>
                    <div class="md-layout-item">
                        <md-field>
                            <label for="diperbarui">Diperbarui</label>
                            <md-input name="diperbarui" id="diperbarui" v-model="form.diperbarui" :disabled="true" />
                        </md-field>
                    </div>
                </div>
                <md-field>
                    <label for="deskripsi">Deskripsi</label>
                    <md-textarea name="deskripsi" id="deskripsi" md-counter="150" v-model="form.deskripsi"
                        :disabled="editstat" />
                </md-field>
            </md-card-content>
            <md-progress-bar md-mode="indeterminate" v-if="sending" />
        </md-card>
        <md-snackbar :md-active.sync="userSaved" style="align: center;"> {{ lastUser }}, Tiketmu berhasil diubah
        </md-snackbar>
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
      name: 'detail',
      props: {
          lb: String,
          req_id: Number
      },
      mixins: [validationMixin],
      data: () => ({
          form: {
              nama: "",
              pic: "",
              kategori: "",
              prioritas: "",
              status: "",
              dibuat: "",
              diperbarui: "",
              deskripsi: ""
          },
          sending: false,
          btsimpan: false,
          editstat: true,
          detail_js: [],
          lastUser: "",
          userSaved: false
      }),
      computed: {
          ...mapState([
            'stat_js',
            'kategori_kat',
            'prio_js',
            'pic_js'
          ])
      },
      mounted() {
          this.getData()
          this.getJsondata()
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
              pic: {
                  required
              },
              status: {
                  required
              },
              prioritas: {
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
          switchidup: function (event) {
              this.editstat = ![event]
              this.btsimpan = [event]
          },
          switchmati: function (event) {
              this.$v.$touch()
                  if (!this.$v.$invalid) {
                      this.saveUser()
                  }
              this.editstat = [event]
              this.btsimpan = ![event]
              this.refresh()
          },
          saveUser() {
                  this.sending = true
                  var id = `${this.req_id}`
                  var a = `${this.form.nama}`
                  var b = `${this.form.prioritas}`
                  var c = `${this.form.pic}`
                  var d = `${this.form.kategori}`
                  var e = `${this.form.status}`
                  if(e = 1){
                      e = 2
                  }
                  var f = `${this.form.deskripsi}`
                  var post_req = '/api/ticket/edit/' + id + '?a=' + a +'&b=' + b + '&c=' + c + '&d=' + d + '&e=' + e + '&f=' + f  
                  // Instead of this timeout, here you can call your API
                  axios
                    .put(post_req)
                  window.setTimeout(() => {
                      this.lastUser = `${this.form.nama}`
                      this.userSaved = true
                      this.sending = false
                      this.getData()
                      this.refresh()
                  }, 1500)
              },
          tidakaktif: function (event) {
              switch (event) {
                  case 3:
                      return true
                  case 2:
                      return false
                  case 1:
                      return false
              }
          },
          dis: function (event) {
              switch (event) {
                  case 3:
                      return 'rgba(0, 0, 0, 0.26)'
                  case 2:
                      return 'color: #eb2f06'
                  case 1:
                      return 'color: #eb2f06'
              }
          },
          refresh() {
              this.$emit('refresh')
          },
          close() {
              this.$emit('close')
          },
          getData() {
              if(!this.req_id){
                  return null
              }else{
                  var det = '/api/ticket/' + this.req_id
                  return axios
                      .get(det)
                      .then(response => (this.form.deskripsi = response.data.data.deskripsi_masalah,
                          this.form.nama = response.data.data.diajukan_oleh,
                          this.form.pic = response.data.data.pic_id,
                          this.form.prioritas = response.data.data.prioritas_id,
                          this.form.kategori = response.data.data.kategori_id,
                          this.form.status = response.data.data.stat_id,
                          this.form.dibuat = response.data.data.created_at,
                          this.form.diperbarui = response.data.data.updated_at
                      ))
              }
          },
          getJsondata() {
          this.kategori_kat = this.katjson
          this.pic_js = this.picjson
          this.prioritas_js = this.priojson
          this.stat_js = this.statjson
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
        min-height: 100vh;
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