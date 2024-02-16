
<link rel="stylesheet" href="resources\sass\button_neumorphic.scss">

<div class="btn-group">
<button id="userTrend" class="btn-group__item btn-group__item">User Trend</button><button id="transactionTrend" class="btn-group__item">Transaction Trend</button><button id="plans" class="btn-group__item">Plans</button>
</div>

@push('styles')
    <style>
        @charset "UTF-8";
/** base styles **/
@import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400&display=swap");



/** button group styles **/
.btn-group {
	margin-top: 50px;
    border-radius: 1rem;
	display: flex;
	height: 200px;
	flex-direction: column;

    	color: #333;
	font-family: 'Nunito Sans' ,-apple-system, BlinkMacSystemFont, 
 "Segoe UI", "Roboto", "Oxygen", 
 "Ubuntu", "Cantarell", "Fira Sans", 
 "Droid Sans", "Helvetica Neue", sans-serif;
	box-shadow: -2.3px -2.3px 3.8px rgba(255, 255, 255, 0.2), -6.3px -6.3px 10.6px rgba(255, 255, 255, 0.3), -15.1px -15.1px 25.6px rgba(255, 255, 255, 0.4), -50px -50px 85px rgba(255, 255, 255, 0.07), 2.3px 2.3px 3.8px rgba(0, 0, 0, 0.024), 6.3px 6.3px 10.6px rgba(0, 0, 0, 0.035), 15.1px 15.1px 25.6px rgba(0, 0, 0, 0.046), 50px 50px 85px rgba(0, 0, 0, 0.07);
}

.btn-group__item {
	border: none;
	min-width: 6rem;
	padding: 1rem 1rem;
	
	background-color: #eee;
	cursor: pointer;
	margin: 5;
	box-shadow: inset 0px 0px 0px -15px rebeccapurple;
	transition: all 300ms ease-out;
	border-radius: 1rem;
}

/* .btn-group__item:last-child {
	border-top-right-radius: 1rem;
	border-bottom-right-radius: 1rem;
}

.btn-group__item:first-child {
	border-top-left-radius: 1rem;
	border-bottom-left-radius: 1rem;
} */

.btn-group__item:hover {
	color: orange;
	box-shadow: inset 0px -20px 0px -15px orange;
}

.btn-group__item:focus {
	color: rebeccapurple;
	box-shadow: inset 0px -20px 0px -15px rebeccapurple;
}

.btn-group__item:focus {
	outline: none;
}

.btn-group__item:after {
	content: '✔️';
	margin-left: 0.5rem;
	display: inline-block;
	color: rebeccapurple;
	position: absolute;
	transform: translatey(10px);
	opacity: 0;
	transition: all 200ms ease-out;
}

.btn-group__item--active:after {
	opacity: 1;
	transform: translatey(-2px);
}
    </style>
@endpush


@push('scripts')
    <script>
        const buttons = document.querySelectorAll(".btn-group__item");
        buttons.forEach(button => {
        button.addEventListener("click",(event) => {
            // do some action according to button
            switchGraph(event)
        })
        })
    </script>
@endpush