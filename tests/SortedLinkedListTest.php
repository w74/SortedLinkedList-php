<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\{CoversClass, UsesClass};
use SortedLinkedList\SortedLinkedList;
use SortedLinkedList\LinkedListNode;

#[CoversClass(SortedLinkedList::class)]
#[UsesClass(LinkedListNode::class)]
final class SortedLinkedListTest extends TestCase {

    public function testThrowsErrorOnMismatchedValueType(): void
    {
        $list = new SortedLinkedList();
        $node1 = new LinkedListNode('hello');
        $node2 = new LinkedListNode(1234);

        $list->addValue($node1);

        $this->expectException(RuntimeException::class);

        $list->addValue($node2);
    }

    public function testAddingValues(): void
    {
        $list = new SortedLinkedList();

        $list->addValue(new LinkedListNode(1));
        $list->addValue(new LinkedListNode(3));

        $this->expectOutputString('1,3,');

        $list->printEntireList();
    }

    public function testSortingValues(): void
    {
        $list = new SortedLinkedList();
        $list->addValue(new LinkedListNode('z'));
        $list->addValue(new LinkedListNode('y'));
        $list->addValue(new LinkedListNode('x'));

        $this->expectOutputString('x,y,z,');

        $list->printEntireList();
    }

    public function testDeletingValues(): void
    {
        $list = new SortedLinkedList();

        $node = new LinkedListNode(3);

        $list->addValue($node);
        $list->addValue(new LinkedListNode(1));
        $list->addValue(new LinkedListNode(5));

        $list->removeValue($node);

        $this->expectOutputString('1,5,');

        $list->printEntireList();
    }
}