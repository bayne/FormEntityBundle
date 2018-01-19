<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Symfony\Component\Form\Test\TypeTestCase;

class ChoiceQuestionTypeTest extends TypeTestCase
{
    use ChoiceQuestionTypeFormDataTrait;

    /**
     * This test is incomplete!
     *
     * @dataProvider getValidFormData
     *
     * @param array $formData
     */

    public function testSubmit_ShouldCreateTemplate_FormDataIsValid($formData)
    {
        $this->markTestIncomplete('Default choice question object gets created out of order');

        $form = $this->factory->create(ChoiceQuestionType::class);

        $object = $this->getChoiceQuestionFromFormData($formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

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
                    'position' => 0,
                    'label' => 'Test Label',
                    'multiple' => false,
                    'choices' => []
                ],
            ],
            [
                'formData' => [
                    'position' => 0,
                    'label' => 'Test Label',
                    'multiple' => false,
                    'choices' => [
                        [
                            'label' => 'Choice answer 1',
                            'weight' => null,
                            'position' => 0
                        ],
                        [
                            'label' => 'Choice answer 2',
                            'weight' => null,
                            'position' => 1
                        ],
                    ]
                ],
            ],
            [
                'formData' => [
                    'position' => 0,
                    'label' => 'Test Label',
                    'multiple' => true,
                    'choices' => [
                        [
                            'label' => 'Choice answer 1',
                            'weight' => null,
                            'position' => 0
                        ],
                        [
                            'label' => 'Choice answer 2',
                            'weight' => null,
                            'position' => 1
                        ],
                    ]
                ],
            ]
        ];
    }

}
