import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DepMobMenuComponent } from './dep-mob-menu.component';

describe('DepMobMenuComponent', () => {
  let component: DepMobMenuComponent;
  let fixture: ComponentFixture<DepMobMenuComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DepMobMenuComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DepMobMenuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
