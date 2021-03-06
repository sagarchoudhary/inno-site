<?php

/**
 * @file
 * Contains \Drupal\datetime\Tests\Views\ArgumentDateTimeTest.
 */

namespace Drupal\datetime\Tests\Views;

use Drupal\views\Views;

/**
 * Tests the Drupal\datetime\Plugin\views\filter\Date handler.
 *
 * @group datetime
 */
class ArgumentDateTimeTest extends DateTimeHandlerTestBase {

  /**
   * {@inheritdoc}
   */
  public static $testViews = ['test_argument_datetime'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Add some basic test nodes.
    $dates = [
      '2000-10-10',
      '2001-10-10',
      '2002-01-01',
    ];
    foreach ($dates as $date) {
      $this->nodes[] = $this->drupalCreateNode([
        'field_date' => [
          'value' => $date,
        ]
      ]);
    }
  }

  /**
   * Test year argument.
   *
   * @see \Drupal\datetime\Plugin\views\argument\YearDate
   */
  public function testDatetimeArgumentYear() {
    $view = Views::getView('test_argument_datetime');

    // The 'default' display has the 'year' argument.
    $view->setDisplay('default');
    $this->executeView($view, ['2000']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[0]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();

    $view->setDisplay('default');
    $this->executeView($view, ['2002']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[2]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();
  }

  /**
   * Test month argument.
   *
   * @see \Drupal\datetime\Plugin\views\argument\MonthDate
   */
  public function testDatetimeArgumentMonth() {
    $view = Views::getView('test_argument_datetime');
    // The 'embed_1' display has the 'month' argument.
    $view->setDisplay('embed_1');

    $this->executeView($view, ['10']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[0]->id()];
    $expected[] = ['nid' => $this->nodes[1]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();

    $view->setDisplay('embed_1');
    $this->executeView($view, ['01']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[2]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();
  }

  /**
   * Test day argument.
   *
   * @see \Drupal\datetime\Plugin\views\argument\DayDate
   */
  public function testDatetimeArgumentDay() {
    $view = Views::getView('test_argument_datetime');

    // The 'embed_2' display has the 'day' argument.
    $view->setDisplay('embed_2');
    $this->executeView($view, ['10']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[0]->id()];
    $expected[] = ['nid' => $this->nodes[1]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();

    $view->setDisplay('embed_2');
    $this->executeView($view, ['01']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[2]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();
  }

  /**
   * Test year, month, and day arguments combined.
   */
  public function testDatetimeArgumentAll() {
    $view = Views::getView('test_argument_datetime');
    // The 'embed_3' display has year, month, and day arguments.
    $view->setDisplay('embed_3');

    $this->executeView($view, ['2000', '10', '10']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[0]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();

    $view->setDisplay('embed_3');
    $this->executeView($view, ['2002', '01', '01']);
    $expected = [];
    $expected[] = ['nid' => $this->nodes[2]->id()];
    $this->assertIdenticalResultset($view, $expected, $this->map);
    $view->destroy();
  }

}
