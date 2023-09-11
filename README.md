# структура проекта:
	src/Entity/CalcDelivery - сущность для сохранения результатов расчетов
	src/CalcDeliveryService - сервис для работы с сущностью
	src/Controller/Api/DeliveryApi - 2 endpointa 
	1 endpoint - для Быстрой Доставки
	2 endpoint - для Медленной Доставки
	tests/DeliveryApiTest - модульные тесты. Имитация двух клиентов: для Быстрой доставки и для медленной доставки.
