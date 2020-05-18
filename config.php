<?php


putenv('TEST_AMQP_DEBUG=0');
define('_RABBIT_HOST_', getenv('TEST_RABBITMQ_HOST') ? getenv('TEST_RABBITMQ_HOST') : 'localhost');
define('_RABBIT_PORT_', getenv('TEST_RABBITMQ_PORT') ? getenv('TEST_RABBITMQ_PORT') : 5672);
define('_RABBIT_USER_', getenv('TEST_RABBITMQ_USER') ? getenv('TEST_RABBITMQ_USER') : 'guest');
define('_RABBIT_PASS_', getenv('TEST_RABBITMQ_PASS') ? getenv('TEST_RABBITMQ_PASS') : 'guest');
define('_RABBIT_QUEUE_', 'socket_queue');
define('_RABBIT_EXCHANGE_', 'exchange');
define('_RABBIT_CONSUMER_TAG_', 'c_tag');
define('VHOST', '/');
define('AMQP_DEBUG', getenv('TEST_AMQP_DEBUG') !== false ? (bool)getenv('TEST_AMQP_DEBUG') : false);

define('_RESULT_',__DIR__ . '/result');