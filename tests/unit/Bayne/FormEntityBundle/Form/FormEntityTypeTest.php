<?php

namespace Bayne\FormEntityBundle\Form;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\UserInterface;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator\TextDecoratorTypeFormDataTrait;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Question\ChoiceQuestionTypeFormDataTrait;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Question\TextQuestionTypeFormDataTrait;
use Symfony\Component\Form\Test\TypeTestCase;

class FormEntityTypeTest extends TypeTestCase
{
    use TextQuestionTypeFormDataTrait;
    use TextDecoratorTypeFormDataTrait;
    use FormEntityTypeFormDataTrait;
    use ChoiceQuestionTypeFormDataTrait;

    /**
     * @dataProvider getValidFormData
     *
     * @param array $formData
     */
    public function testSubmit_ShouldCreateFormEntity_FormDataIsValid($formData)
    {
        $user = new class implements UserInterface {};
        $formEntity = new FormEntity($user);
        $form = $this->factory->create(FormEntityType::class, $formEntity);

        $object = $this->getTemplateFromFormData($formData, $user);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());

        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function getValidFormData()
    {
        return [
            [
                'formData' => [
                    'text_question_elements' => [],
                    'choice_question_elements' => [],
                    'title' => 'Empty form'
                ]
            ],
            [
                'formData' => [
                    'choice_question_elements' => [],
                    'text_question_elements' => [
                        [
                            'position' => 0,
                            'label' => 'Text element 1'
                        ],
                        [
                            'position' => 1,
                            'label' => 'Text element 2'
                        ]
                    ],
                    'title' => 'Form with two text elements'
                ]
            ],
            [
                'formData' => [
                    'choice_question_elements' => [],
                    'text_question_elements' => [
                        [
                            'position' => 0,
                            'label' => 'Text element 1'
                        ],
                        [
                            'position' => 1,
                            'label' => 'Text element 1'
                        ]
                    ],
                    'text_decorator_elements' => [
                        [
                            'position' => 1,
                            'text' => 'Text decorator 1'
                        ]
                    ],
                    'title' => 'Form with two text elements and a text decorator'
                ]
            ],
            [
                'formData' => [
                    'text_question_elements' => [
                        [
                            'position' => 0,
                            'label' => 'Text element 1'
                        ],
                    ],
                    'choice_question_elements' => [
                        [
                            'position' => 2,
                            'label' => 'Choice question 1',
                            'multiple' => false,
                            'choices' => [
                                [
                                    'label' => 'Choice answer 1',
                                    'weight' => 0,
                                    'position' => 0
                                ],
                                [
                                    'label' => 'Choice answer 2',
                                    'weight' => 0,
                                    'position' => 1
                                ],
                            ]
                        ]
                    ],
                    'text_decorator_elements' => [
                        [
                            'position' => 1,
                            'text' => 'Text decorator 1'
                        ]
                    ],
                    'title' => 'Form with a text element, a text decorator, and a choice question'
                ]
            ],
            [
                'formData' => [
                    'choice_question_elements' => [
                         [
                            'position' => 0,
                            'label' => 'Choice question 1',
                            'multiple' => false,
                            'choices' => [
                                [
                                    'label' => 'Choice answer 1',
                                    'weight' => 0,
                                    'position' => 0
                                ],
                                [
                                    'label' => 'Choice answer 2',
                                    'weight' => 0,
                                    'position' => 1
                                ],
                            ]
                        ],
                        [
                            'position' => 1,
                            'label' => 'Choice question 2',
                            'multiple' => false,
                            'choices' => [
                                [
                                    'label' => 'Choice answer a',
                                    'weight' => 0,
                                    'position' => 0
                                ],
                                [
                                    'label' => 'Choice answer b',
                                    'weight' => 0,
                                    'position' => 1
                                ],
                            ]
                        ]
                    ],
                    'title' => 'Form with 2 choice questions'
                ]
            ]
        ];
    }


}
