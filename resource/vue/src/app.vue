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
                      <label for="lastName">Cover</label>
                      <img src="https://placekeanu.com/500/500" class="img-fluid general-cover shadow" alt="Responsive image">
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
          image: {value: '', invalid: false},
        },

        domains: [],
        urls: []
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

      this.$api.get ('/domain')
        .then (res => {
          this.domains = res.data;
          this.action.domain_id = res.data[0].id;
        });

      this.latest ()
        .then (res => this.urls = res.data);
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
          //this.action.image.value = res.data.custom_image;

          $('#options-panel').collapse ('show');

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
        };

        this.$api.put (`/url/${act.id}`, data).then (res => {

          this.action.id = res.data.id;
          this.action.domain_id = res.data.domain_id;
          this.action.code.value = res.data.url_code;
          this.action.original.value = res.data.original_url;

          this.action.custom.value = res.data.enable_custom;
          this.action.title.value = res.data.custom_title;
          this.action.description.value = res.data.custom_description;
          //this.action.image.value = res.data.custom_image;

          let idx = _.findIndex (this.urls, {id: res.data.id});

          if (idx >= 0)
            this.urls.splice (idx, 1, res.data);

        }).catch (res => console.log ('catch', res));
      }
    },
  }
</script>
