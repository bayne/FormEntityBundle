<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Symfony\Component\Form\Test\TypeTestCase;

class TextQuestionTypeTest extends TypeTestCase
{
    use TextQuestionTypeFormDataTrait;

    /**
     * @dataProvider getValidFormData
     *
     * @param array $formData
     */
    public function testSubmit_ShouldCreateTemplate_FormDataIsValid($formData)
    {
        $form = $this->factory->create(TextQuestionType::class);

        $object = $this->getTextElementFromFormData($formData);

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
                    'label' => 'Test Label'
                ]
            ]
        ];
    }

}
