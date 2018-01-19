<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator;

use Symfony\Component\Form\Test\TypeTestCase;

class HeaderDecoratorTypeTest extends TypeTestCase
{
    use HeaderDecoratorTypeFormDataTrait;

    /**
     * @dataProvider getValidFormData
     *
     * @param array $formData
     */
    public function testSubmit_ShouldCreateTemplate_FormDataIsValid($formData)
    {
        $form = $this->factory->create(HeaderDecoratorType::class);

        $object = $this->getHeaderDecoratorFromFormData($formData);

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
                    'text' => 'Test text'
                ]
            ]
        ];
    }

}
