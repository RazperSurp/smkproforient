<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts_type}}`.
 */
class m240915_092542_create_contacts_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'alias' => $this->text(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('contacts_type', ['name', 'alias'], [
            ['WhatsApp', 'WS'],
            ['Telegram', 'TG'],
            ['Viber', 'VB'],
            ['VK Messenger', 'VKM'],
            ['Вконтакте', 'VK'],
            ['Одноклассники', 'OK'],
            ['Официальный портал', 'Сайт'],
            ['Номер контактного факса', 'Номер факса'],
            ['Номер контактного телефона', 'Номер тел.'],
            ['Адрес контактной электронной почты', 'Адрес почты'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contacts_type}}');
    }
}
