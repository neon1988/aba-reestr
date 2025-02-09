<?php declare(strict_types=1);

use App\Enums\CurrencyEnum;
use App\Enums\EducationEnum;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\SubscriptionLevelEnum;

return [
    EducationEnum::class => [
        EducationEnum::Secondary => 'Среднее',
        EducationEnum::Vocational => 'Среднее специальное',
        EducationEnum::IncompleteHigher => 'Неполное высшее',
        EducationEnum::Higher => 'Высшее',
        EducationEnum::Master => 'Магистр',
        EducationEnum::Doctorate => 'Доктор наук',
    ],
    SubscriptionLevelEnum::class => [
        SubscriptionLevelEnum::Free => 'Без подписки',
        SubscriptionLevelEnum::A => 'Подписка A',
        SubscriptionLevelEnum::B => 'Подписка B',
        SubscriptionLevelEnum::C => 'Подписка C',
    ],
    CurrencyEnum::class => [
        CurrencyEnum::RUB => 'руб.'
    ],
    PaymentProvider::class => [
        PaymentProvider::YooKassa => 'Ю.Касса'
    ],
    PaymentStatusEnum::class => [
        PaymentStatusEnum::PENDING => 'Ожидает обработки', // Платеж в процессе обработки
        PaymentStatusEnum::SUCCEEDED => 'Успешно завершён', // Платеж был успешно завершён
        PaymentStatusEnum::CANCELED => 'Отменён', // Платеж был отменён
        PaymentStatusEnum::WAITING_FOR_CAPTURE => 'Ожидает подтверждения', // Платеж ожидает подтверждения
        PaymentStatusEnum::DECLINED => 'Отклонён', // Платеж был отклонён
        PaymentStatusEnum::WAITING_FOR_PAYMENT => 'Ожидает оплаты', // Платеж ещё не был произведён
    ],
    StatusEnum::class => [
        StatusEnum::Accepted => 'Принято', // Статус принятия
        StatusEnum::OnReview => 'На проверке', // Статус проверки
        StatusEnum::Rejected => 'Отклонено', // Статус отклонения
        StatusEnum::Private => 'Личное', // Статус, когда запись является личной
        StatusEnum::ReviewStarts => 'Начало проверки', // Статус, когда началась проверка
    ],
];
