<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $attributesData = [
                [
                    'category'    => 'Грим и линзы',
                    'subcategory' => 'Косметика',
                    'attributes'  => [
                        ['name' => 'Тип косметики', 'type' => 'list', 'options' => ['Тональный крем', 'Пудра и румяна', 'Тени', 'Помада', 'Уход за кожей', 'Средства для укладки волос'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Грим и линзы',
                    'subcategory' => 'Линзы',
                    'attributes'  => [
                        ['name' => 'Цвет', 'type' => 'radio', 'options' => ['Коричневый', 'Черный', 'Красный', 'Зеленый', 'Синий', 'Желтый', 'Голубой', 'Оранжевый', 'Розовый', 'Фиолетовый', 'Пепельный', 'Разноцветный'], 'comment' => 'Значение в виде цветного кружочка'],
                        ['name' => 'Диоптрии', 'type' => 'list', 'options' => ['от -5 до +5'], 'comment' => 'Чекбокс "Диоптрии". Чекед - появляется list.'],
                        ['name' => 'Рисунок', 'type' => 'list', 'options' => ['Шаринган/ренинган', 'кошачий глаз', 'змеиный глаз', 'бельмо', 'Рисунок'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Грим и линзы',
                    'subcategory' => 'Пластический грим',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Накладки на лицо', 'Молды', 'Накладные уши', 'Клей и материалы'], 'comment' => 'null'],
                        ['name' => 'Тип косметики', 'type' => 'list', 'options' => ['Тональный крем', 'Пудра и румяна', 'Тени', 'Помада', 'Уход за кожей', 'Средства для укладки волос'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Основное',
                    'subcategory' => 'Доставка',
                    'attributes'  => [
                        ['name' => 'Пересылка', 'type' => 'checkbox', 'options' => ['Пересылка'], 'comment' => 'null'],
                        ['name' => 'Отправка за границу ', 'type' => 'checkbox', 'options' => ['Отправка за границу '], 'comment' => 'Появляется, если предыдущий чекед'],
                    ],
                ],
                [
                    'category'    => 'Коллекции',
                    'subcategory' => 'Атрибутика',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Значки', 'флаги', 'украшения', 'Брелки', 'Канцелярия', 'Дакимакуры'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Коллекции',
                    'subcategory' => 'Мягкие игрушки',
                    'attributes'  => [
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Заводское', 'ручное'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Коллекции',
                    'subcategory' => 'Печатные издания',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Книга', 'Манга', 'Комикс', 'Артбуки и фотобуки', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Коллекции',
                    'subcategory' => 'Принты и открытки',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Открытки', 'Плакаты', 'Фотографии', 'Коллекционные карточки', 'Календари', 'другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Коллекции',
                    'subcategory' => 'Фигурки',
                    'attributes'  => [
                        ['name' => 'фендом', 'Персонаж ', 'type' => 'input', 'options' => 'input', 'comment' => 'Пока в бэклог'],
                        ['name' => 'Серия и производитель', 'type' => 'list', 'options' => ['Funko Pop', 'Экшен фигурки', 'Куклы', 'Nendroid', 'Cu-Poche', 'Medicom', 'Gentle giant', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Головные уборы',
                    'attributes'  => [
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Кигуруми',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Косплей',
                    'attributes'  => [
                        ['name' => 'Для кого', 'type' => 'radio', 'options' => ['Для мужчин', 'для женщин', 'унисекс'], 'comment' => 'null'],
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                        ['name' => 'фендом', 'Персонаж ', 'type' => 'input', 'options' => 'input', 'comment' => 'Пока в бэклог'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Материалы для пошива',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Ткань', 'Фурнитура', 'Инструмент'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Обувь для косплея',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['32-46'], 'comment' => 'В поиске отображать диапазоном '],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Силиконовые торсы и бюсты',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Мужской торс', 'женский бюст', 'накладки на тело'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Костюмы',
                    'subcategory' => 'Фурсьюты',
                    'attributes'  => [
                        ['name' => 'Комплектация', 'type' => 'list', 'options' => ['Фулл', 'Полуфулл', 'Фулл патриал', 'Патриал', 'Мини патриал', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Материал маски', 'type' => 'list', 'options' => ['3D-печать (пластик)', 'Поролон', 'Eva-foam', 'Папье-маше', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Крафт',
                    'subcategory' => 'Аксессуары',
                    'attributes'  => [
                        ['name' => 'Материалы и технологии', 'type' => 'Check', 'options' => ['Eva-foam', 'ПВХ листовой', 'Жидкий пластик', 'Дерево', 'Металл', 'Ворбла', 'Пеноплекс', 'Резина', 'Латекс', 'Эпоксидка', 'Светодиоды', 'Дым-машина', '3D печать'], 'comment' => 'null'],
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Крылья', 'Ушки и хвосты', 'Рога', 'Сумки'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Ручное', 'Заводское'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Крафт',
                    'subcategory' => 'Доспехи',
                    'attributes'  => [
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Ручное', 'Заводское'], 'comment' => 'null'],
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Материалы и технологии', 'type' => 'Check', 'options' => ['Eva-foam', 'ПВХ листовой', 'Жидкий пластик', 'Дерево', 'Металл', 'Ворбла', 'Пеноплекс', 'Резина', 'Латекс', 'Эпоксидка', 'Светодиоды', 'Дым-машина', '3D печать'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Крафт',
                    'subcategory' => 'Материалы',
                    'attributes'  => [
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Материалы для крафта', 'Инструменты'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Крафт',
                    'subcategory' => 'Оружие',
                    'attributes'  => [
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Ручное', 'Заводское'], 'comment' => 'null'],
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Холодное оружие', 'Стрелковое оружие', 'Огнестрельное оружие', 'Магическое оружие', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Материалы и технологии', 'type' => 'Check', 'options' => ['Eva-foam', 'ПВХ листовой', 'Жидкий пластик', 'Дерево', 'Металл', 'Ворбла', 'Пеноплекс', 'Резина', 'Латекс', 'Эпоксидка', 'Светодиоды', 'Дым-машина', '3D печать'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Крафт',
                    'subcategory' => 'Украшения и бижутерия',
                    'attributes'  => [
                        ['name' => 'Материалы и технологии', 'type' => 'Check', 'options' => ['Eva-foam', 'ПВХ листовой', 'Жидкий пластик', 'Дерево', 'Металл', 'Ворбла', 'Пеноплекс', 'Резина', 'Латекс', 'Эпоксидка', 'Светодиоды', 'Дым-машина', '3D печать'], 'comment' => 'null'],
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Короныи диадемы', 'Мелкая бутафория', 'Ювелирные украшения', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Ручное', 'Заводское'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Одежда',
                    'subcategory' => 'Купальники и белье',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Для кого', 'type' => 'radio', 'options' => ['Для мужчин', 'для женщин', 'унисекс'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Одежда',
                    'subcategory' => 'Одежда в стиле Лолита',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Стиль', 'type' => 'list', 'options' => ['Готик', 'Свит', 'Классик', 'Панк', 'Гуро', 'Химе', 'Одзи', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Для кого', 'type' => 'radio', 'options' => ['Для мужчин', 'для женщин', 'унисекс'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Одежда',
                    'subcategory' => 'Повседневная обувь',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['32-46'], 'comment' => 'В поиске отображать диапазоном '],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Одежда',
                    'subcategory' => 'Повседневная одежда',
                    'attributes'  => [
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                        ['name' => 'Для кого', 'type' => 'radio', 'options' => ['Для мужчин', 'для женщин', 'унисекс'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Одежда',
                    'subcategory' => 'Униформы',
                    'attributes'  => [
                        ['name' => 'Размер', 'type' => 'list', 'options' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Универсальный размер'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Тип', 'type' => 'list', 'options' => ['Костюмы горничных', 'Школьная форма', 'Военная форма', 'Медицинская форма', 'Другое'], 'comment' => 'null'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Фабричное', 'Профессиональный пошив под заказ', 'Любительский пошив под заказ'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Парики',
                    'subcategory' => 'Без укладки',
                    'attributes'  => [
                        ['name' => 'Длина', 'type' => 'list', 'options' => ['Длинный', 'средний', 'короткий'], 'comment' => 'null'],
                        ['name' => 'Цвет', 'type' => 'radio', 'options' => ['Коричневый', 'Черный', 'Блонд', 'Красный', 'Зеленый', 'Синий', 'Желтый', 'Голубой', 'Рыжий', 'Розовый', 'Фиолетовый', 'Перельный', 'Разноцветный'], 'comment' => 'Значение в виде цветного кружочка'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Особенности', 'type' => 'Check', 'options' => ['Лейсфронт, старая сеточка, челка'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Парики',
                    'subcategory' => 'Лысины',
                    'attributes'  => [
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Тип лысины', 'type' => 'list', 'options' => ['Полная лысина', 'Лысина с элементами парика'], 'comment' => 'null'],
                        ['name' => 'Цвет', 'type' => 'radio', 'options' => ['Коричневый', 'Черный', 'Блонд', 'Красный', 'Зеленый', 'Синий', 'Желтый', 'Голубой', 'Рыжий', 'Розовый', 'Фиолетовый', 'Перельный', 'Разноцветный'], 'comment' => 'Значение в виде цветного кружочка'],
                        ['name' => 'Производство', 'type' => 'radio', 'options' => ['Заводское', 'любительское'], 'comment' => 'null'],
                    ],
                ],
                [
                    'category'    => 'Парики',
                    'subcategory' => 'С укладкой',
                    'attributes'  => [
                        ['name' => 'Длина', 'type' => 'input', 'options' => ['Длинный', 'средний', 'короткий'], 'comment' => 'null'],
                        ['name' => 'Цвет', 'type' => 'list', 'options' => ['Коричневый', 'Черный', 'Блонд', 'Красный', 'Зеленый', 'Синий', 'Желтый', 'Голубой', 'Рыжий', 'Розовый', 'Фиолетовый', 'Перельный', 'Разноцветный'], 'comment' => 'null'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                        ['name' => 'Особенности', 'type' => 'Check', 'options' => ['Лейсфронт, старая сеточка, челка, каркасный, разборный, с крафтом'], 'comment' => 'null'],
                        ['name' => 'фендом', 'Персонаж ', 'type' => 'input', 'options' => 'input', 'comment' => 'Пока в бэклог'],
                    ],
                ],
                [
                    'category'    => 'Парики',
                    'subcategory' => 'Шиньоны и трессы',
                    'attributes'  => [
                        ['name' => 'Длина', 'type' => 'list', 'options' => ['Длинный', 'средний', 'короткий'], 'comment' => 'null'],
                        ['name' => 'Цвет', 'type' => 'radio', 'options' => ['Коричневый', 'Черный', 'Блонд', 'Красный', 'Зеленый', 'Синий', 'Желтый', 'Голубой', 'Рыжий', 'Розовый', 'Фиолетовый', 'Перельный', 'Разноцветный'], 'comment' => 'Значение в виде цветного кружочка'],
                        ['name' => 'Состояние', 'type' => 'radio', 'options' => ['Новый', 'как новый', 'хорошее', 'такое себе', 'на расходники'], 'comment' => 'null'],
                    ],
                ],
            ];

            foreach ($attributesData as $data) {
                $category = Category::firstOrCreate(['name' => $data['category']]);
                if (isset($data['subcategory'])) {
                    $subcategory = Category::firstOrCreate(['name' => $data['subcategory'], 'parent_id' => $category->id]);
                }

                foreach ($data['attributes'] as $attributeData) {
                    $attribute = Attribute::firstOrCreate([
                        'name'    => $attributeData['name'],
                        'type'    => $attributeData['type'],
                        'options' => $attributeData['options'],
                        'comment' => $attributeData['comment'],
                    ]);

                    try {
                        $subcategory->attributes()->attach($attribute->id);
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }
    }
}
