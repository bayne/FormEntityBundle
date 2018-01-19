<?php


namespace Bayne\FormEntityBundle\View\Common\JSON\Form;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormView;

class JsonFormViewTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonFormViewTrait
     */
    private $traitObject;
    /**
     * @var int
     */
    private $nameIterator = 1;

    protected function setUp()
    {
        $this->traitObject = $this->getMockForTrait(JsonFormViewTrait::class);
        $this->nameIterator = 1;
    }

    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testGetNormalizedFormView_ShouldNormalizeFormView_EmptyFormView()
    {
        $formView = $this->getFormView();
        $normalized = $this->traitObject->getNormalizedFormView($formView);

        $this->assertEquals(
            [
                'children' => [],
                'vars' => [
                    'name' => 'name_1'
                ],
                'count' => 0
            ],
            $normalized
        );
    }

    public function testGetNormalizedFormView_ShouldNormalizeFormView_DeepNestedFormView()
    {
        $children = [$this->getFormView()];
        for ($i = 0; $i < 5; $i++) {
            $formView = $this->getFormView($children);
            $children = [$formView];
        }

        $normalized = $this->traitObject->getNormalizedFormView($formView);

        $this->assertEquals(
            [
                'children' => [
                    'name_5_form' => [
                        'children' => [
                            'name_4_form' => [
                                'children' => [
                                    'name_3_form' => [
                                        'children' => [
                                            'name_2_form' => [
                                                'children' => [
                                                    'name_1_form' => [
                                                        'children' => [],
                                                        'vars' => [
                                                            'name' => 'name_1'
                                                        ],
                                                        'count' => 0
                                                    ]
                                                ],
                                                'vars' => [
                                                    'name' => 'name_2'
                                                ],
                                                'count' => 1
                                            ]
                                        ],
                                        'vars' => [
                                            'name' => 'name_3'
                                        ],
                                        'count' => 1
                                    ]
                                ],
                                'vars' => [
                                    'name' => 'name_4'
                                ],
                                'count' => 1
                            ],
                        ],
                        'vars' => [
                            'name' => 'name_5'
                        ],
                        'count' => 1
                    ],
                ],
                'vars' => [
                    'name' => 'name_6'
                ],
                'count' => 1
            ],
            $normalized
        );
    }

    public function testGetNormalizedView_ShouldNormalizeFormView_ContainsErrors()
    {
        $formView = $this->getFormView(
            [],
            [
                'error message 1',
                'error message 2'
            ]
        );

        $normalized = $this->traitObject->getNormalizedFormView($formView);

        $this->assertEquals(
            [
                'children' => [],
                'vars' => [
                    'errors' => [
                        'error message 1',
                        'error message 2',
                    ],
                    'name' => 'name_1'
                ],
                'count' => 0
            ],
            $normalized
        );
    }

    public function testGetNormalizedView_ShouldSetValueBlank_ValueIsObject()
    {
        $formView = $this->getFormView(
            [],
            [],
            new \stdClass()
        );

        $normalized = $this->traitObject->getNormalizedFormView($formView);

        $this->assertEquals(
            [
                'children' => [],
                'vars' => [
                    'name' => 'name_1',
                    'value' => ''
                ],
                'count' => 0
            ],
            $normalized
        );
    }

    public function testGetNormalizedView_ShouldSetValueBlank_ValueIsValid()
    {
        $formView = $this->getFormView(
            [],
            [],
            'value!'
        );

        $normalized = $this->traitObject->getNormalizedFormView($formView);

        $this->assertEquals(
            [
                'children' => [],
                'vars' => [
                    'name' => 'name_1',
                    'value' => 'value!'
                ],
                'count' => 0
            ],
            $normalized
        );
    }

    public function getFormView($children = [], $errorMessages = [], $value = '')
    {
        return \Mockery::mock(
            FormView::class,
            function ($mock) use ($children, $errorMessages, $value) {
                $mock->shouldReceive('count')->andReturn(count($children));
                $mock->children = $children;
                $mock->vars = [
                    'name' => 'name_'.$this->nameIterator++
                ];

                if ($value) {
                    $mock->vars['value'] = $value;
                }

                if (count($errorMessages) > 0) {
                    $errors = [];
                    foreach ($errorMessages as $errorMessage) {
                        $errors[] = \Mockery::mock(
                            FormError::class,
                            function ($m) use ($errorMessage) {
                                $m->shouldReceive('getMessage')->andReturn($errorMessage);
                            }
                        );
                    }
                    $mock->vars['errors'] = $errors;
                }
            }
        );
    }

}
