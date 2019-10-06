<!--
  *
  * Template
  *
  -->
<template>
  <div id="app">
    <header>
      <div class="navbar navbar-dark bg-wrinkle shadow-sm">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="@/assets/img/logo.svg" width="20" height="20" class="mr-2" />
            <strong>Wrinkle</strong>
          </a>
          <!--
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          -->
        </div>
      </div>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12 col-md-10">

              <h1 class="jumbotron-heading">Wrinkle</h1>
              <p class="lead text-muted">Simplify your links</p>
              <div class="input-group input-group-lg mt-5">
                <!--
                <div class="input-group-prepend">
                  <button class="btn btn-outline-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">//{{ activeDomain.host }}<sub>{{ activeDomain.path }}</sub></button>
                  <div class="dropdown-menu">
                    <a v-for="domain in domains" class="dropdown-item" @click.prevent="action.domain_id=domain.id" href="#">//{{ domain.host }}<sub>{{ domain.path }}</sub></a>
                  </div>
                </div>
                -->
                <input type="text" class="form-control splice-input" :class="{'is-invalid': action.long.invalid}" @keyup.enter="shorten" placeholder="Paste long URL" v-model="action.long.value">
                <div class="input-group-append">
                  <button type="button" @click="shorten" class="btn-lg btn-wrinkle ml-3">Shorten</button>
                </div>
              </div>

            </div>
          </div>
          <div id="options-panel" class="collapse row justify-content-center mt-5">
            <div class="col-11 text-left shadow-sm p-5 bg-light rounded position-relative">

              <div class="position-absolute option-close-button">
                <button type="button" class="close" aria-label="Close" data-toggle="collapse" data-target="#options-panel" aria-controls="options-panel" aria-expanded="false" >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="row">
                <div class="col-lg-5 col-xl-6">

                  <h4 class="mb-4">Shortened Link Option</h4>

                  <div class="mb-3">
                    <label for="lastName">Short URL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">{{ activeDomain|domainUrl }}</span>
                      </div>
                      <input type="text" class="form-control" :class="{'is-invalid': action.code.invalid}" placeholder="Custom URL" v-model="action.code.value">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-info"><i class="fa fa-copy"></i></button>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="firstName">Domain</label>
                    <select class="custom-select d-block w-100" v-model="action.domain_id">
                      <option v-for="domain in domains" :value="domain.id">{{ domain|domainUrl }}</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="lastName">Original URL</label>
                    <input type="text" class="form-control" :class="{'is-invalid': action.original.invalid}" placeholder="Original URL" v-model="action.original.value">
                  </div>

                </div>
                <div class="col-lg-7 col-xl-6 mt-5 mt-lg-0">

                  <h4 class="mb-4">Advenced Option</h4>

                  <div class="row">
                    <div class="col-md-6 order-md-2 mb-3">
                      <label for="lastName">Cover <small :class="{'d-none': !dzImageIsUpdated}" class="dz-reset text-danger" @click="dzReset"><i class="fa fa-undo ml-2 font-small"></i></small></label>
                      <!--
                      <div id="dropzone" class="border shadow position-relative w-100" @drop.prevent="attachImage" @dragover.stop.self.prevent="showAttachTips (); consolelog('over')" @dragleave.stop.self.prevent="hideAttachTips (); consolelog('leave')" @dragexit.stop.self.prevent="consolelog('exit')" @dragenter.stop.self.prevent="consolelog('enter')">
                      -->
                      <div id="dropzone" :class="{'empty-image': dzImageIsEmpty, 'shadow': !dzImageIsEmpty}" class="position-relative w-100"
                        @click.prevent="dzClick"
                        @drop.prevent="dzAttachFile"
                        @mouseover.prevent="dzTipHandler"
                        @mouseleave.prevent="dzTipHandler"
                        @dragover.prevent="dzTipHandler"
                        @dragleave.prevent="dzTipHandler">
                        <div class="tip-layer position-absolute w-100 h-100" style="top: 0; left: 0;">
                          <p>Drop file or click to upload</p>
                        </div>
                        <img :src="dzImageSrc" class="preview img-fluid general-cover">
                        <input @click.stop="" @change="dzAttachFile" ref="dzFile" type="file" class="d-none">
                      </div>
                    </div>
                    <div class="col-md-6 order-md-1">

                      <div class="row">
                        <div class="col-12 mb-3">
                          <label for="firstName">Title</label>
                          <input type="text" class="form-control" :class="{'is-invalid': action.title.invalid}" placeholder="Title" v-model="action.title.value">
                        </div>
                        <div class="col-12 mb-3">
                          <label for="lastName">Description</label>
                          <textarea type="text" class="form-control description-text" :class="{'is-invalid': action.description.invalid}" placeholder="Description" v-model="action.description.value"></textarea>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </div>

              <hr class="mb-4" />

              <button class="btn btn-wrinkle btn-lg btn-block mt-4" @click="update" :disabled="action.id == 0">Save</button>

            </div>
          </div>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <h2>Links</h2>
          <div class="mt-5 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="10%">#</th>
                  <th width="25%">Short<span class="d-none d-sm-none d-md-none d-lg-inline"> URL</span></th>
                  <th>Original<span class="d-none d-sm-none d-md-none d-lg-inline"> URL</span></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="url in urls">
                  <td>{{ url.id }}</td>
                  <td><a class="text-dark" :href="url|urlLink" target="_blank">{{ url|urlLink }}</a></td>
                  <td><a class="text-dark" :href="url.original_url" target="_blank">{{ url.original_url }}</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!--
      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      -->

      <div class="fixed-bottom w-100" aria-live="polite" aria-atomic="true">
        <div style="position: absolute; bottom: 20px; right: 20px;">

          <div v-for="message in messages" v-if="message.show" class="toast" style="bottom: 300px" role="alert" aria-live="assertive" aria-atomic="true" :data-time="message.time">
            <div class="toast-header">
              <i :class="message.icon" width="20" height="20" class="mr-2" />
              <strong class="mr-auto">{{ message.title || 'Wrinkle' }}</strong>
              <small class="text-muted">just now</small>
              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
              {{ message.message }}
            </div>
          </div>

        </div>
      </div>

    </main>

    <footer class="my-4 pt-4 text-muted text-center text-small">
      <p class="mb-1">Made with <span class="text-danger">❤</span> in Taiwan ． Power by Protype</p>
    </footer>

  </div>
</template>

<!--
  *
  * Style
  *
  -->
<style>
@import url('https://fonts.googleapis.com/css?family=Playfair+Display:700,900');
textarea.form-control.description-text {
  height: 125px;
}
</style>


<!--
  *
  * Script
  *
  -->
<script>

  // Import
  import _ from "lodash";

  // Components

  // Component
  export default {

    /**
     *
     * Inner components
     *
     */
    components: {
    },


    /**
     *
     * Data
     *
     */
    data: () => {
      return {

        action: {
          id: 0,
          domain_id: 0,
          long: {value: '', invalid: false},
          code: {value: '', invalid: false},
          original: {value: '', invalid: false},
          custom: {value: false, invalid: false},
          title: {value: '', invalid: false},
          description: {value: '', invalid: false},
          image: {name: null, data: null, value: '', cache: '', invalid: false},
        },

        domains: [],
        urls: [],
        messages: []
      }
    },


    /**
     *
     * Computed
     *
     */
    computed: {

      activeDomain () {
        return _.find (this.domains, {id: this.action.domain_id}) || {host: '', path: ''};
      },

      dzImageSrc () {
        return this.action.image.value == ''
          ? 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='
          : this.action.image.value;
      },

      dzImageIsEmpty () {
        return this.action.image.value == '';
      },

      dzImageIsUpdated () {
        return this.action.image.value != this.action.image.cache;
      }
    },


    /**
     *
     * Filter
     *
     */
    filters: {


      /**
       *
       * Domain for display
       *
       */
      domainUrl (domain) {

        if (! domain || ! domain.host)
          return '';

        return domain.scheme + '://' + domain.host + domain.path + '/';
      },


      /**
       *
       * Short url
       *
       */
      urlLink (url) {

        let scheme = 'http://';

        if (url.domain && url.domain.scheme)
          scheme = url.domain.scheme;

        return `${scheme}://${url.short_url}`;
      }
    },


    /**
     *
     * Created
     *
     */
    created () {

      let $vmc = this;

      this.$api.get ('/domain')
        .then (res => {
          this.domains = res.data;
          this.action.domain_id = res.data[0].id;
        });

      this.latest ()
        .then (res => this.urls = res.data);

      this.$nextTick (() => {
        $('body').on ('hidden.bs.toast', '.toast', function () {

          let $this = $(this)
            , time = $this.data ('time')
            , counter = 0
            , index
            ;

          $vmc.messages.forEach (m => {

            if (m.time == time)
              m.show = false;

            m.show && counter++;
          })

          if (counter == 0)
            $vmc.messages.splice (0, $vmc.messages.length);
        });
      })
    },


    /**
     *
     * Methods
     *
     */
    methods: {


      /**
       *
       * Retrieve latest data
       *
       */
      latest () {

        let after = '';

        if (this.urls.length > 0)
          after = `&after=${this.urls[0].id}`;

        return this.$api.get (`/url?cursour=id${after}&order=desc`);
      },


      /**
       *
       * Retrieve previous data
       *
       */
      previous () {

        let before = '', url;

        if (this.urls.length > 0) {
          url = this.urls[this.urls.length - 1];
          before = `&before=${url.id}`;
        }

        return this.$api.get (`/url?cursour=id&${before}&order=desc`);
      },


      /**
       *
       * shorten
       *
       */
      shorten () {

        this.action.long.invalid = false;

        if (this.action.long.value == '') {
          this.action.long.invalid = true;
          return;
        }

        this.$api.post ('/url', {
          domain_id: this.action.domain_id,
          original_url: this.action.long.value
        }).then (res => {

          this.action.id = res.data.id;
          this.action.domain_id = res.data.domain_id;
          this.action.code.value = res.data.url_code;
          this.action.original.value = res.data.original_url;

          this.action.custom.value = res.data.enable_custom;
          this.action.title.value = res.data.custom_title;
          this.action.description.value = res.data.custom_description;
          this.action.image.value = res.data.custom_image;
          this.action.image.cache = res.data.custom_image;
          //this.action.image.value = res.data.custom_image;

          $('#options-panel').collapse ('show');

          this.toast ('success', 'Shorten Success', 'Target URL shortened successfully.')

          this.latest ().then (res => this.urls = res.data.concat (this.urls));

        }).catch (res => console.log ('catch', res) );
      },


      /**
       *
       * update
       *
       */
      update () {

        let fields = ['code', 'original', 'title', 'description']
          , act = this.action
          , err = 0;
          ;

        fields.forEach (f => act[f].invalid = false);

        if (act.code.value == '')
          (act.code.invalid = true) && err++;

        if (act.original.value == '')
          (act.original.invalid = true) && err++;

        if (err > 0)
          return;

        let data = {
          domain_id: this.action.domain_id,
          url_code: this.action.code.value,
          original_url: this.action.original.value,
          custom_title: this.action.title.value,
          custom_description: this.action.description.value,
          custom_image: {
            file_name: this.action.image.name,
            file_data: this.action.image.data
          }
        };

        this.$api.put (`/url/${act.id}`, data).then (res => {

          this.action.id = res.data.id;
          this.action.domain_id = res.data.domain_id;
          this.action.code.value = res.data.url_code;
          this.action.original.value = res.data.original_url;

          this.action.custom.value = res.data.enable_custom;
          this.action.title.value = res.data.custom_title;
          this.action.description.value = res.data.custom_description;
          this.action.image.value = res.data.custom_image;
          this.action.image.cache = res.data.custom_image;

          let idx = _.findIndex (this.urls, {id: res.data.id});

          if (idx >= 0)
            this.urls.splice (idx, 1, res.data);

          this.toast ('success', 'Update Success', 'Shortened link updated successfully.')

        }).catch (res => console.log ('catch', res));
      },


      /**
       *
       * Dropzone attach file handler
       *
       */
      toast (type, title, message) {

        let icon = '';

        switch (type) {

          case 'success':
            icon = 'fa fa-check-circle toast-icon toast-success';
            break;

          case 'warning':
            icon = 'fa fa-warning toast-icon toast-warning';
            break;
        }

        this.messages.push ({
          show: true,
          time: new Date ().getTime (),
          icon,
          title,
          message
        });

        this.$nextTick (() => $('.toast').toast ({delay: 6000}).toast ('show'));
      },


      /**
       *
       * Dropzone click action
       *
       */
      dzClick ($e) {
        this.$refs.dzFile.click ();
      },


      /**
       *
       * Dropzone tip message handler
       *
       */
      dzTipHandler ($e) {

        switch ($e.type || '') {

          case 'mouseover':
            $('#dropzone').addClass ('mouseover');
            break;

          case 'mouseleave':
            $('#dropzone').removeClass ('mouseover');
            break;

          case 'dragover':
            $('#dropzone').addClass ('dragover');
            break;

          case 'dragleave':
            $('#dropzone').removeClass ('dragover');
            break;
        }
      },


      /**
       *
       * Reset dropzone
       *
       */
      dzReset () {

        if (! confirm ('Reset cover image ?'))
          return;

        this.action.image.value = this.action.image.cache;
        this.action.image.name = null;
        this.action.image.data = null;

        //this.toast ('warning', 'Reset Success', 'The cover image has been successfully reset.');
      },


      /**
       *
       * Dropzone attach file handler
       *
       */
      dzAttachFile ($e) {

        let files;

        if ($e.type == 'drop' && $e.dataTransfer && $e.dataTransfer.files.length > 0)
          files = $e.dataTransfer.files;

        else if ($e.type == 'change' && $e.target.files && $e.target.files.length > 0)
          files = $e.target.files;

        if (! files)
          return;

        let $vmc = this
          , file = files[0]
          , reader = new FileReader ()
          , $dz = $('#dropzone')
          , $img = $dz.find ('.preview')
          ;

        reader.onload = $e => {

          let dataurl = $e.target.result;

          $vmc.action.image.name = file.name;
          $vmc.action.image.data = dataurl.substr (dataurl.indexOf ('base64') + 7);
          $vmc.action.image.value = dataurl;

          $img.hasClass ('d-none') && $img.addClass ('d-block');
          $dz.removeClass ('mouseover');
          $dz.removeClass ('dragover');
        };

        reader.readAsDataURL (file);
      }
    },
  }
</script>
