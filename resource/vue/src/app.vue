<!--
  *
  * Template
  *
  -->
<template>
  <div id="app">
    <header>
      <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <strong>Wrinkled</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

    <main role="main">

      <section class="jumbotron text-center">
        <div class="container-fluid">
          <div class="row justify-content-md-center">
            <div class="col-10">

              <h1 class="jumbotron-heading">Wrinkled</h1>
              <p class="lead text-muted">Simplify your links</p>
              <div class="input-group input-group-lg mt-5">
                <input type="text" class="form-control splice-input" placeholder="Paste long URL" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                <div class="input-group-append">
                  <button type="button" class="btn-lg btn-secondary ml-3">Shorten</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

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

    </main>

    <footer class="my-4 pt-4 text-muted text-center text-small">
      <p class="mb-1">&copy; 2019 Wrinkled</p>
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
</style>


<!--
  *
  * Script
  *
  -->
<script>

  // Import

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
      }
    },


    /**
     *
     * Created
     *
     */
    created () {
      this.$api.get ('/url')
        .then (res => console.log (res));
    },


    /**
     *
     * Computed
     *
     */
    computed: {
    },


    /**
     *
     * Methods
     *
     */
    methods: {
    },
  }
</script>
