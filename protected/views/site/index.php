Проверяем работу авторизации через соц сети:
<ol>
<li><?php echo CHtml::link('Вконтакте', $VkAuth->getLink()); ?> - сделано</li>
<li><?php echo CHtml::link('Facebook', $FbAuth->getLink()); ?> - в тесте</li>
</ol>
<?# var_dump($_SESSION);?>
<?php if ( ! empty($_SESSION['vk'])) { ?>
	VK:
	<pre>
	<?php var_dump($VkAuth->call('getProfiles', array('uid' => $_SESSION['vk']['uid'], 'fields'=>'uid, first_name, last_name, nickname, domain, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online'), $_SESSION['vk']['access_token'])); ?>
	</pre>
<?php } ?>


<?php if ( $fbProfile = $FbAuth->getData()) { ?>
	FB:
	<pre>
	<?php var_dump($fbProfile); ?>
	</pre>
<?php } ?>

<?php #var_dump($_SESSION); ?>


