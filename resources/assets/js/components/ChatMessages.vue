<template>
	<ul class="chat">
		<li class="left clearfix" v-for="message in messages">
			<div class="chat-body clearfix">
				<div class="header">
					<strong class="primary-forn">
						{{ message.user.name }}
					</strong>
				</div>
				<p>
					{{ message.message }}
				</p>
			</div>
		</li>
	</ul>
</template>

<script>
	export default {
		props: ['messages'],

		sockets: {
			message (data) {
				let message = JSON.parse(data);
				console.log('Success: Notification sent!');
			}
		}
	};
</script>