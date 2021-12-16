
const CityList = {
    data() {
        return {
            cities: [
                {
                    id: 1,
                    name: "Lincoln City",
                    visited: true
                },
                {
                    id: 2,
                    name: "Port Townsend",
                    visited: true
                },
                {
                    id: 3,
                    name: "Chicago",
                    visited: true
                },
                {
                    id: 4,
                    name: "Coos Bay",
                    visited: true
                }
            ],
        };
    },
    computed: {
        visitedCities() {
            return this.cities.filter(city => city.visited);
        },
    },
}

City = {
    props: ['city'],
    template: `<li>{{ city.name }}<input
    type="checkbox" v-model="city.visited"></li>`
}

app2 = Vue.createApp(CityList);
app2.component('city-list', City);
app2.mount("#cities");