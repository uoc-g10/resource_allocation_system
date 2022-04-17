<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> ReserveX - Online allocation systems </title>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/android-chrome-512x512.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/android-chrome-192x192.png">	
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bower_components/scheduler/jquery.skedTape.css">
	<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../bower_components/dist/css/AdminLTE.css">
	<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../bower_components/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../bower_components/calender/evo-calendar.min.css">
	<link rel="stylesheet" href="../public/css/jq.schedule.min.css">
	<!-- <link rel="stylesheet" href="../public/css/default.css"> -->
	<!-- <link rel="stylesheet" href="../public/css/default.time.css"> -->
	<link rel="stylesheet" href="../public/css/classic.css">
	<link rel="stylesheet" href="../public/css/classic.time.css">
	<link rel="stylesheet" href="../public/css/jnoty.min.css">
	<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../public/css/popModal.css">
	<link rel="stylesheet" href="../public/css/colorPick.css">
	<!-- <link rel="stylesheet" href="../public/css/duDatepicker.min.css"> -->
	<link rel="stylesheet" href="../public/css/fullCalender.css">
	<link rel="stylesheet" href="../public/css/jquery.timeline.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@banminkyoz/lightpick@1.2.12/css/lightpick.css">
	<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />

	<!-- If you use the default popups, use this. -->
	<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
	<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

	<link rel="stylesheet" href="../bower_components/style.css">

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style type="text/css">
		.mt20 {
			margin-top: 20px;
		}

		.bold {
			font-weight: bold;
		}

		/* chart style*/
		#legend ul {
			list-style: none;
		}

		#legend ul li {
			display: inline;
			padding: 2px 8px 2px 28px;
			position: relative;
			/*margin-bottom: 4px;*/
			border-radius: 5px;
			font-size: 14px;
			cursor: default;
			-webkit-transition: background-color 200ms ease-in-out;
			-moz-transition: background-color 200ms ease-in-out;
			-o-transition: background-color 200ms ease-in-out;
			transition: background-color 200ms ease-in-out;
		}

		#legend li span {
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			width: 20px;
			height: 100%;
			border-radius: 5px;
		}

		.swal2-popup {
			font-size: 1.6rem !important;
			border-radius: 0 !important;
		}
	</style>
</head>

<body class="hold-transition skin-blue sidebar-mini <?php echo isset($_COOKIE['sidebar-collapse']) ? 'sidebar-collapse' : '' ?>">