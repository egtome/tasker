<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('title', TextType::class, ['label' => 'Title']);
        $builder->add('content', TextareaType::class, ['label' => 'Content','attr' => ['class' => 'task-description']]);
        $builder->add('priority', ChoiceType::class, ['label' => 'Priority',
                                                       'choices' => ['Select Priority' => '','High' => 'high','Medium' => 'medium','Low' => 'low']]);
        $builder->add('hours', NumberType::class, ['label' => 'Estimated Hours']);        
        $builder->add('submit', SubmitType::class, ['label' => 'Create Task']);
    }
}

/*
 * 'id', 'int', 'NO', 'PRI', NULL, 'auto_increment'
'user_id', 'int', 'NO', 'MUL', NULL, ''
'title', 'varchar(255)', 'YES', '', NULL, ''
'content', 'text', 'YES', '', NULL, ''
'priority', 'varchar(20)', 'YES', '', NULL, ''
'hours', 'decimal(10,2)', 'YES', '', NULL, ''
'created_at', 'datetime', 'YES', '', NULL, ''

 */