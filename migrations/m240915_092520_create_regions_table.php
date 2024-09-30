<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regions}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%countries}}`
 */
class m240915_092520_create_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'countries_id' => $this->integer(),
            'name' => $this->text(),
        ]);

        // creates index for column `countries_id`
        $this->createIndex(
            '{{%idx-regions-countries_id}}',
            '{{%regions}}',
            'countries_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            '{{%fk-regions-countries_id}}',
            '{{%regions}}',
            'countries_id',
            '{{%countries}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('regions', ['countries_id', 'name'], [
            [
                [1, 'Республика Адыгея'],
                [1, 'Республика Алтай'],
                [1, 'Республика Башкортостан'],
                [1, 'Республика Бурятия'],
                [1, 'Республика Дагестан'],
                [1, 'Донецкая Народная Республика'],
                [1, 'Республика Ингушетия'],
                [1, 'Кабардино-Балкарская Республика'],
                [1, 'Республика Калмыкия'],
                [1, 'Карачаево-Черкесская Республика'],
                [1, 'Республика Карелия'],
                [1, 'Республика Коми'],
                [1, 'Республика Крым'],
                [1, 'Луганская Народная Республика'],
                [1, 'Республика Марий Эл'],
                [1, 'Республика Мордовия'],
                [1, 'Республика Саха'],
                [1, 'Республика Северная Осетия'],
                [1, 'Республика Татарстан'],
                [1, 'Республика Тыва'],
                [1, 'Удмуртская Республика'],
                [1, 'Республика Хакасия'],
                [1, 'Чеченская Республика'],
                [1, 'Чувашская Республика'],
                [1, 'Алтайский край'],
                [1, 'Забайкальский край'],
                [1, 'Камчатский край'],
                [1, 'Краснодарский край'],
                [1, 'Красноярский край'],
                [1, 'Пермский край'],
                [1, 'Приморский край'],
                [1, 'Ставропольский край'],
                [1, 'Хабаровский край'],
                [1, 'Амурская область'],
                [1, 'Архангельская область'],
                [1, 'Астраханская область'],
                [1, 'Белгородская область'],
                [1, 'Брянская область'],
                [1, 'Владимирская область'],
                [1, 'Волгоградская область'],
                [1, 'Вологодская область'],
                [1, 'Воронежская область'],
                [1, 'Запорожская область'],
                [1, 'Ивановская область'],
                [1, 'Иркутская область'],
                [1, 'Калининградская область'],
                [1, 'Калужская область'],
                [1, 'Кемеровская область'],
                [1, 'Кировская область'],
                [1, 'Костромская область'],
                [1, 'Курганская область'],
                [1, 'Курская область'],
                [1, 'Ленинградская область'],
                [1, 'Липецкая область'],
                [1, 'Магаданская область'],
                [1, 'Московская область'],
                [1, 'Мурманская область'],
                [1, 'Нижегородская область'],
                [1, 'Новгородская область'],
                [1, 'Новосибирская область'],
                [1, 'Омская область'],
                [1, 'Оренбургская область'],
                [1, 'Орловская область'],
                [1, 'Пензенская область'],
                [1, 'Псковская область'],
                [1, 'Ростовская область'],
                [1, 'Рязанская область'],
                [1, 'Самарская область'],
                [1, 'Саратовская область'],
                [1, 'Сахалинская область'],
                [1, 'Свердловская область'],
                [1, 'Смоленская область'],
                [1, 'Тамбовская область'],
                [1, 'Тверская область'],
                [1, 'Томская область'],
                [1, 'Тульская область'],
                [1, 'Тюменская область'],
                [1, 'Ульяновская область'],
                [1, 'Херсонская область'],
                [1, 'Челябинская область'],
                [1, 'Ярославская область'],
                [1, 'Москва'],
                [1, 'Санкт-Петербург'],
                [1, 'Севастополь'],
                [1, 'Еврейская автономная область'],
                [1, 'Ненецкий автономный округ'],
                [1, 'Ханты-Мансийский автономный округ'],
                [1, 'Чукотский автономный округ'],
                [1, 'Ямало-Ненецкий автономный округ']
            ]
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%countries}}`
        $this->dropForeignKey(
            '{{%fk-regions-countries_id}}',
            '{{%regions}}'
        );

        // drops index for column `countries_id`
        $this->dropIndex(
            '{{%idx-regions-countries_id}}',
            '{{%regions}}'
        );

        $this->dropTable('{{%regions}}');
    }
}
