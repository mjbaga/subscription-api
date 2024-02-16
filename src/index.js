// Simple Vue implementation of homepage with list and form
Vue.createApp({
    data() {
        return {
            subscribers: [],
            page: 1,
            totalPages: null,
            data: {
                name: '',
                lastName: '',
                status: ''
            },
            formMessage: ''
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

            fetch('/subscribers/?' + params)
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
        },
        submitForm(){
            var formData = {
                name: this.data.name,
                last_name: this.data.lastName,
                status: this.data.status
            };

            this.postData("/subscribers/add/", formData)
                .then((data) => {
                    console.log(data);

                    this.formMessage = data.message;

                    this.data.name = '';
                    this.data.lastName = '';
                    this.data.status = 'active';
                });

        },
        async postData(url, formData) {
        
            var response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
                
            return response.json();

        }
    }
}).mount('#app')