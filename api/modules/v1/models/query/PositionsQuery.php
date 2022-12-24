<?php

namespace api\modules\v1\models\query;

/**
 * This is the ActiveQuery class for [[\api\modules\v1\models\Positions]].
 *
 * @see \api\modules\v1\models\Positions
 */
class PositionsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 1]);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\Positions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \api\modules\v1\models\Positions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
