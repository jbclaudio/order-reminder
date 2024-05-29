<script>
export default {
        render() {
            return this.$scopedSlots.default(this)
        },
        props: {
            productIds: {
                type: Array,
                required: false
            },
            orderReminder: {
                type: [Object,Boolean],
                required: false,
                default: false
            },
            defaultTimespan: {
                type: Number,
                required: false,
                default: 1
            }
        },
        data() {
            return {
                show: false,
                variables: {
                    email: localStorage.getItem('email') || '',
                    timespan: 1,
                    products: []
                }
            }
        },
        methods: {
            toggleForm() {
                this.show = !this.show
            },
            submitForm() {
                window.rapidezAPI(
                    this.orderReminder ? 'put' : 'post',
                    'order-reminders' + (this.orderReminder ? '/' + this.orderReminder.id : ''),
                    {
                        email: this.variables.email,
                        timespan: this.variables.timespan,
                        products: this.variables.products
                    }
                ).then(response => {
                    this.toggleForm()
                    if (this.orderReminder) {
                        Notify(window.config.translations.order_reminder.update
                            .replace('%1', `${response.orderReminder.timespan} ${window.config.translations.order_reminder.week[+(response.orderReminder.timespan !== 1)]}`)
                            .replace('%2', new Date(response.orderReminder.reminder_date)
                                .toLocaleDateString(window.navigator.language,
                                    { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }))
                        , 'success')
                        window.app.$emit('refreshOrderReminders')
                    } else {
                        Notify(window.config.translations.order_reminder.add, 'success')
                    }
                }).catch(response => {
                    this.toggleForm()
                    if (response?.response?.status === 403) {
                        Notify(window.config.translations.order_reminder.unauthorized, 'error')
                    } else {
                        Notify(window.config.translations.order_reminder.error, 'error')
                    }
                })
            },
            submitDelete() {
                if (confirm(window.config.translations.order_reminder.confirm_delete)) {
                    window.rapidezAPI(
                        'delete',
                        `order-reminders/${ this.orderReminder.id }`,
                        {}
                    ).then(() => {
                        this.toggleForm()
                        Notify(window.config.translations.order_reminder.delete, 'success')
                        window.app.$emit('refreshOrderReminders')
                    })
                }
            }
        },
        watch: {
            productIds: function(newVal, oldVal) {
                if (!window.app.$data.loading) {
                    this.variables.products = this.productIds
                }
            }
        },
        mounted() {
            if (this.orderReminder) {
                this.variables.email = this.orderReminder.email
                this.variables.timespan = this.orderReminder.timespan
                this.variables.products = Object.values(this.orderReminder.products).map(item => item.entity_id)
            } else if (this.productIds && this.productIds.length === 1) {
                this.variables.products.push(this.productIds[0])
                this.variables.timespan = this.defaultTimespan
            }

        }
    }
</script>
