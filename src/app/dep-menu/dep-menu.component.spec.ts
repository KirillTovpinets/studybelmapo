import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DepMenuComponent } from './dep-menu.component';

describe('DepMenuComponent', () => {
  let component: DepMenuComponent;
  let fixture: ComponentFixture<DepMenuComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DepMenuComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DepMenuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
