<template>
    <div class="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h4>Calendar</h4>
            </div>
            <div class="text item">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Event</label>
                                <input type="text" @keyup="reEvaluate" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Event Title" @change="reEvaluate" v-model="event.title">
                                <div class="invalid-feedback" v-if="errors.title">
                                    {{errors.title[0]}}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">From</label>
                                <input type="date" @keyup="reEvaluate" name="" class="form-control form-control-sm" v-model="event.start" id="">
                                <div class="invalid-feedback" v-if="errors.start">
                                    {{errors.start[0]}}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">To</label>
                                <input type="date" @keyup="reEvaluate" name="" class="form-control form-control-sm" v-model="event.end" id="">
                                <div class="invalid-feedback" v-if="errors.end">
                                    {{errors.end[0]}}
                                </div>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="Monday">
                                <label class="form-check-label" for="inlineRadio1">Mon</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio2" value="Tuesday">
                                <label class="form-check-label" for="inlineRadio2">Tue</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="Wednesday" >
                                <label class="form-check-label" for="inlineRadio3">Wed</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="Thursday" >
                                <label class="form-check-label" for="inlineRadio3">Thu</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="Friday" >
                                <label class="form-check-label" for="inlineRadio3">Fri</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="Saturday" >
                                <label class="form-check-label" for="inlineRadio3">Sat</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @change="reEvaluate" v-model="event.days" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="Sunday" >
                                <label class="form-check-label" for="inlineRadio3">Sun</label>
                            </div>
                            <div class="invalid-feedback" v-if="errors.days">
                                    {{errors.days[0]}}
                                </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" @click="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="calendar">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <th colspan="3" style="border-top: none; border-bottom: 3px solid black">{{ getYearMonth }}</th>
                                </thead>
                                <tbody>
                                    <div v-show="list">
                                        <div v-for="(date, index) in events" :key="index">
                                            <tr v-for="(td, index) in add_rows(date)" :key="index">
                                                <td>{{ td.day }}</td>
                                                <td>{{ td.day_name }}</td>
                                                <td style="width:100%; text-align: center">{{ td.description }}</td>
                                            </tr>
                                        </div>
                                    </div>
                                    <div v-show="!list">
                                        <tr v-for="(ca, index) in calendars" :key="index">
                                            <td>{{ca.day}}</td>
                                            <td>{{ca.day_name}}</td>
                                            <td style="width:100%; text-align: center">{{ca.description}}</td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </el-card>

    </div>
</template>
<script>
export default {
    name: 'CalendarEventHome',
    data() {
        return {
            event : {
                title: null,
                start: null,
                end: null,
                days: []
            },
            on_change: false,
            events: [],
            calendars: [],
            list: false,
            errors: []
        }
    },
    created() {
        this.getEvents()
    },
    methods: {
        getEvents() {
            this.$API.Event_api.getEvents()
                .then(res => {
                    this.events = res.data
                    if(this.events.length > 0) {
                        this.list = true;
                        console.log(this.list);
                    }
                })
        },
        async submit() {
            try {
                const res = await this.$API.Event_api.saveEvent(this.event);
                this.event = {
                    title: null,
                    start: null,
                    end: null,
                    days: []
                }
                console.log(res);
                this.errors = []
                this.getEvents();
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors
                        break;

                    default:
                        console.log(error);
                        break;
                }
            }
        },
        reEvaluate() {
            this.on_change = true

            let days  = this.getCheckboxFilters();
            let inputsAsDate = [{
            'from': this.getDate(this.event.start),
            'to': this.getDate(this.event.end),
            'event': this.event.title,
            'days': days
            }]
            this.dates = inputsAsDate
            this.rows = []
        },
        breakdown(date) {
            try{
            this.error = false
            let year = date.getFullYear()
            let month = date.toLocaleString('default', { month: 'long' })

            return {'what_year': year, 'what_month': month}
            }catch(e){ this.error = true}
        },
        getCheckboxFilters(){
            return this.event.days;
        },
        getDate(input){
            return input?new Date(input) : new Date()
        },
        getDayName(day) {
            let days = this.getWeekDays()
            return days[day]
        },
        getWeekDays(){
            return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
        },
        add_rows(date) {
            //get each day from start to end date
            const theDate = this.getDate(date.start)
            const endDate = this.getDate(date.end)

            let localOrDatabaseEvent = this.on_change? this.event.title : date.title
            let localOrDatabaseDays = this.on_change? this.getCheckboxFilters() : date.days
            let filters = date.days
            let rows = []

            while (theDate <= endDate) {
            let dataForEachLine = {}
            dataForEachLine.day = theDate.getDate()
            dataForEachLine.day_name = this.getDayName(theDate.getDay())

            let description = this.getDescriptionByFilter(theDate.getDay(), localOrDatabaseEvent, localOrDatabaseDays)
            dataForEachLine.description = description

            rows.push(dataForEachLine)
            theDate.setDate(theDate.getDate() + 1)  //icrement each day
            }
            this.on_change = false;

            return rows
        },

        getDescriptionByFilter(day, description, filters){
            let has_filter = false
            let filters_str = filters.toString().replace(/[[\]"]/g,'')
            let filters_arr = filters_str.split(',')

            let week_days = this.getWeekDays()

            for(let i=0; i < filters_arr.length; i++){
            if(filters_arr[i] == week_days[day]){
                has_filter = true
                return description
            }
            if(has_filter) break
            has_filter = false
            }
            return ''
        },
        getDays(year, month) { // single
            let monthIndex = new Date(Date.parse(month + " 1, 2012")).getMonth() + 1 - 1; // 0..11 instead of 1..12
            let names = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'thursday', 'Friday', 'Saturday' ];
            let date = new Date(year, monthIndex, 1);
            let res = [];
            while (date.getMonth() == monthIndex) {
            //   result.push(date.getDate() + '-' + names[date.getDay()]);
                let result = {}
                result.day = date.getDate();
                result.day_name = names[date.getDay()];
                result.description = ' '
                res.push(result);
              date.setDate(date.getDate() + 1);
            }
            this.calendars = res
            return res;
        },
    },
    computed: {
        from() {
            let date = this.getDate(this.event.start)
            return this.breakdown(date)
        },
        to() {
            let date = this.getDate(this.event.end)
            return this.breakdown(date)
        },
        getYearMonth(){
            if(!this.event.start && !this.event.end){
                this.getDays(this.from.what_year, this.from.what_month)
                return this.from.what_month + ' ' + this.from.what_year
            }
            return this.from.what_month + ' ' + this.from.what_year + ' - ' + this.to.what_month + ' ' + this.to.what_year
        },
        getDates() {
            let start = this.getDate(this.event.start)
            let end = this.getDate(this.event.end)
            return this.getDatesBetweenDates(start, end)
        }
    }
}
</script>

<style >
    .form {
        padding: 10px;
    }
    .calendar {
        padding: 10px;
    }
    .invalid-feedback {
        display: inline !important;
    }
</style>
