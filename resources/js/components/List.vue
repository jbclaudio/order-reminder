<script>
    export default {
        render() {
            return this.$scopedSlots.default(this)
        },
        data() {
            return {
                orderReminders: {}
            }
        },
        methods: {
            getOrderReminders() {
                axios.get('/api/order-reminders', {
                    headers: { 'Authorization': `Bearer ${localStorage.token}` }
                }).then(response => {
                    this.orderReminders = response.data.orderReminders.sort((a, b) => Date.parse(a.reminder_date) - Date.parse(b.reminder_date));
                })
            }
        },
        created() {
            window.app.$on('refreshOrderReminders', () => {
                this.getOrderReminders()
            })
        },
        mounted() {
            window.app.$emit('refreshOrderReminders')
        }
    }
</script>
