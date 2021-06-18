 // --------------------------- Data --------------------------------
 var locations = [{
    id: '1',
    name: 'Dr. Rohan Samarasighe',
    //tzOffset: 7 * 60
    // tzOffset: 0
},
{
    id: '2',
    name: 'Mrs. Nethmini Weerasinghe',
    // tzOffset: -10 * 60
    // tzOffset: 0
},
{
    id: '3',
    name: 'Mr. Navod Thilakarathna',
    // tzOffset: 4 * 60
    // tzOffset: 0
},
{
    id: '4',
    name: 'Mrs. Sherina Selly',
    // tzOffset: -1 * 60
    // tzOffset: 0
},
{
    id: '5',
    name: 'Mr. Eshana',
    // tzOffset: -2 * 60
    //tzOffset: 0
},
{
    id: '6',
    name: 'Mrs. Yasara Samarasighe',
    // tzOffset: -2 * 60
    //tzOffset: 0
},
];

var events = [{
    name: 'Lecture 1',
    location: '2',
    start: today(7, 30),
    end: today(9, 0)
},
{
    name: 'Revision',
    location: '3',
    start: today(6, 0),
    end: today(7, 15)
},
{
    name: 'Lecture 2',
    location: '2',
    start: today(13, 0),
    end: today(15, 0)
},
{
    name: 'PHP Revision',
    location: '4',
    start: today(9, 30),
    end: today(11, 0)
},
{
    name: 'C Revision',
    location: '4',
    start: today(15, 30),
    end: today(17, 0)
},
{
    name: 'Meeting',
    location: '5',
    start: today(0, 0),
    end: today(1, 30)
},
];

// -------------------------- Helpers ------------------------------
function today(hours, minutes) {
var date = new Date();
date.setHours(hours, minutes, 0, 0);
return date;
}

function yesterday(hours, minutes) {
var date = today(hours, minutes);
date.setTime(date.getTime() - 24 * 60 * 60 * 1000);
return date;
}

function tomorrow(hours, minutes) {
var date = today(hours, minutes);
date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
return date;
}

// --------------------------- Example 1 ---------------------------
var $sked1 = $('#sked1').skedTape({
caption: 'Lectureres',
start: today(6, 0),
end: today(18, 0),
showEventTime: true,
showEventDuration: true,
scrollWithYWheel: true,
locations: locations.slice(),
events: events.slice(),
showPopovers: 'always',
// maxTimeGapHi: 60 * 1000, // 1 minute
// minGapTimeBetween: 1 * 60 * 1000,
// snapToMins: 1,
// editMode: true,
//timeIndicatorSerifs: true,
// showIntermission: true,
tzOffset: -330,
sorting: true,
formatters: {
    date: function(date) {
        console.log($.fn.skedTape.format.date(date, 'l', '.'));
        return $.fn.skedTape.format.date(date, 'l', '.');
    },
    duration: function(ms, opts) {
        return $.fn.skedTape.format.duration(ms, {
            hrs: 'h',
            min: 'min'
        });
    },
},
canAddIntoLocation: function(location, event) {
    return location.id == '1';
},

beforeAddIntoLocation: function(location, event) {
    console.log(location)
    return location.id != '1';
},

postRenderLocation: function($el, location, canAdd) {
    this.constructor.prototype.postRenderLocation($el, location, canAdd);
    $el.prepend('<i class="fas fa-thumbtack text-muted"/> ');
}
});

$sked1.on('event:dragEnded.skedtape', function(e) {
console.log(e.detail.event);
});

$sked1.on('event:click.skedtape', function(e) {
if (e.detail.event.locationId == '1') {
    alert(e.detail.event.id);
}

//$sked1.skedTape('removeEvent', e.detail.event.id);
});

console.log(today(6, 0));

function newReservation() {
$sked1.skedTape('startAdding', {
    name: 'New meeting',
    location: '1',
    start: today(6, 0),
    end: today(7, 0),
    className: 'new-added',
    duration: 60 * 60 * 1000
});
}

$sked1.on('timeline:click.skedtape', function(e, api) {
try {
    newReservation();
} catch (e) {
    if (e.name !== 'SkedTape.CollisionError') throw e;
    alert('Already exists');
}
});