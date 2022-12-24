<?php

use yii\db\Migration;

/**
 * Class m221222_162009_create_roles_for_admin
 */
class m221222_162009_create_roles_for_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createResume" permission
        $createResume              = $auth->createPermission('createResume');
        $createResume->description = 'Create a resume';
        $auth->add($createResume);


        // add "createVacancy" permission
        $createVacancy              = $auth->createPermission('createVacancy');
        $createVacancy->description = 'Create a vacancy';
        $auth->add($createVacancy);


        // add "viewClicks" permission
        $viewClicks              = $auth->createPermission('viewClicks');
        $viewClicks->description = 'View all clicks (for recruiters)';
        $auth->add($viewClicks);


        // add "viewAllVacancies" permission
        $viewAllVacancies              = $auth->createPermission('viewAllVacancies');
        $viewAllVacancies->description = 'View all vacancies';
        $auth->add($viewAllVacancies);


        // add "viewWeeklyVacancies" permission
        $viewWeeklyVacancies              = $auth->createPermission('viewWeeklyVacancies');
        $viewWeeklyVacancies->description = 'View weekly vacancies';
        $auth->add($viewWeeklyVacancies);


        // add "deleteVacancy" permission
        $deleteVacancy              = $auth->createPermission('deleteVacancy');
        $deleteVacancy->description = 'Delete vacancies';
        $auth->add($deleteVacancy);


        // add "deleteResume" permission
        $deleteResume             = $auth->createPermission('deleteResume');
        $deleteResume->description = 'Delete resume';
        $auth->add($deleteResume);



        // create role 'applicant' and attach permission(s) to it
        $applicant = $auth->createRole('applicant');
        $auth->add($applicant);
        $auth->addChild($applicant, $createResume);
        $auth->addChild($applicant, $deleteResume);


        // create role 'recruiter' and attach permission(s) to it
        $recruiter = $auth->createRole('recruiter');
        $auth->add($recruiter);
        $auth->addChild($recruiter, $createVacancy);
        $auth->addChild($recruiter, $viewClicks);
        $auth->addChild($recruiter, $deleteVacancy);


        // create role 'admin' and attach permission(s) to it
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createResume);
        $auth->addChild($admin, $createVacancy);
        $auth->addChild($admin, $viewClicks);
        $auth->addChild($admin, $viewAllVacancies);
        $auth->addChild($admin, $viewWeeklyVacancies);
        $auth->addChild($admin, $deleteVacancy);
        $auth->addChild($admin, $deleteResume);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        echo "m221222_162009_create_roles_for_admin cannot be reverted.\n";
        return false;
    }
}
