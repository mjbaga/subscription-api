// Simple Vue implementation of homepage with list and form
Vue.createApp({
    data() {
        return {
            subscribers: [],
            page: 1,
            totalPages: null,
        }
    },
    mounted() {
        this.getSubscribers()
    },
    methods: {
        getSubscribers(){
            var params = new URLSearchParams({
                page: this.page
            });

            fetch('/subscribers?' + params)
                .then(r => r.json())
                .then(json => {
                    this.subscribers = json.data;
                    this.totalPages = json.totalPages;
                });
        },
        getPreviousSubs() {
            if(this.page > 1) {
                this.page-=1;
                this.getSubscribers();
            }
        },
        getNextSubs() {
            if(this.page < this.totalPages) {
                this.page+=1;
                this.getSubscribers();
            }
        }

    }
}).mount('#app')