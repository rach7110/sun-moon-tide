<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sun Moon</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bulma -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    </head>

    <body>
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
              <a class="navbar-item" href="https://bulma.io">
                Sun Moon Tide
              </a>

              <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
              </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
              <div class="navbar-start">
                <a class="navbar-item">
                  Home
                </a>

                <a class="navbar-item">
                  Documentation
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                  <a class="navbar-link">
                    More
                  </a>

                  <div class="navbar-dropdown">
                    <a class="navbar-item">
                      About
                    </a>
                    <a class="navbar-item">
                      Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                      Report an issue
                    </a>
                  </div>
                </div>
              </div>

              <div class="navbar-end">
                <div class="navbar-item">
                  <div class="buttons">
                    <a class="button is-primary">
                      <strong>Sign up</strong>
                    </a>
                    <a class="button is-light">
                      Log in
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </nav>

        <div class="container" id="root">
            <section class="hero is-primary">
                <div class="hero-body">
                  <p class="title">
                    Climate Data
                  </p>
                  <p class="subtitle">
                    See what the sun, moon, and tide are up to today.
                </p>
                </div>
              </section>

              <p>Errors</p>
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

            <div>
                <form action="/api/climate" method="POST">
                    @csrf
                    <div class="field">
                        <label class="label" for="zip">Zip</label>
                        <div class="control">
                            <input class="input" type="text" v-model=zip placeholder="78704" name="zip" required="required"/>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="date">Station ID</label>
                        <div class="control">
                            <input class="input" type="text" v-model=stationId name="stationId" required="required"/>
                        </div>
                    </div>

                    <a href="https://tidesandcurrents.noaa.gov/map/" target="blank">Station Lookup</a>

                    <div class="field">
                        <label class="label" for="timezone">Timezone</label>
                        <div class="control">
                            <input class="input" type="text" v-model=timezone placeholder="-5" name="timezone" required="required"/>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="date">Date</label>
                        <div class="control">
                            <input class="input" type="text" v-model=date name="date" required="required"/>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button" type="submit"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

{{-- <script src="https://unpkg.com/vue@next"></script> --}}

<script>
    // const ClimateData = {
    //     data() {
    //         return {
    //             zip: '',
    //             stationId: '',
    //             date: '',
    //             timezone: '',
    //         }
    //     },
    //     computed: {
    //         disableClimateSubmit() {
    //             return this.zip === '' || this.date === '' || this.timezone === '';
    //         },
    //     },
    // }

    // const app = Vue.createApp(ClimateData);
    // const vm = app.mount('#root');

</script>

<style>
    body {
        font-family: 'Nunito', sans-serif;
    }
</style>
