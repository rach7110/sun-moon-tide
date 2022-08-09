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
              <a class="navbar-item navbar-item--white" href="{{route('welcome')}}">
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
                    <a class="navbar-item" href="https://github.com/rach7110/sun-moon-tide#readme" target="_blank">
                        Documentation
                    </a>
                    <a class="navbar-item" href="https://github.com/rach7110/sun-moon-tide/pulls" target="_blank">
                        Report an issue
                    </a>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                    <div class="buttons">
                        <form href="{{route('logout')}}" method="POST">
                                @csrf
                                <input class="navbar-item button" value="Logout" type="submit"/>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
          </nav>

        <div class="container is-max-desktop min-h-screen" id="root">
            <section class="notification notification--green is-primary">
                <div class="">
                  <p class="title">
                    Climate Data
                  </p>
                    <p class="subtitle">
                    See what the sun, moon, and tide are up to today.
                </p>
              </section>

              @if ($errors->any())
              <p>Errors</p>
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

            <div class="container is-max-desktop">
                <form action="/api/climate" method="POST">
                    @csrf
                    <div class="field">
                        <label class="label" for="zip">Zip</label>
                        <div class="control">
                            <input class="input" type="text" value="78704" placeholder="78704" name="zip" required="required"/>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="date">Station ID</label>
                        <div class="control">
                            <input class="input" type="text" value="9435380" name="stationId" required="required"/>
                        </div>
                        <a class="link--gray" href="https://tidesandcurrents.noaa.gov/map/" target="blank">Station Lookup</a>
                    </div>


                    <div class="field">
                        <label class="label" for="timezone">Timezone</label>
                        <div class="control">
                            <input class="input" type="text" value="-55" placeholder="-5" name="timezone" required="required"/>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="date">Date</label>
                        <div class="control">
                            <input class="input" type="text" value="01-05-2022" name="date" required="required"/>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button button--green" type="submit" value="Submit"/>
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
        background-color: #1a202c;
        margin-bottom: 71px;
    }
    nav.navbar {
        background-color: #1a202c;
    }

    .navbar-item--white {
        color: #e0e1e4;
    }

    label.label {
        color: #e0e1e4;
        font-size: 1.1rem;
    }

    .link--gray {
        color: #a0aec0;
    }
    .input {
        color: #e0e1e4;
        background-color: #2d3748
    }
    .notification--green.notification.is-primary {
        background-color: #127369;
    }

    .button.button--green {
        background-color: #8AA6A3;
        border-color: #8AA6A3;
    }
    .min-h-screen {
        min-height: 100vh;
    }
</style>
